#!/usr/bin/env bash
# Instanță MySQL locală, proprie a userului OS (NU serviciul de sistem — port 3306
# rămâne al lui `mysql.service`; acest script pornește propriul datadir/port/socket,
# fără sudo). Vezi prompts/_ENV.md §4/§9 și FIX-01.
set -euo pipefail

DIR="$HOME/mysql-local-lumea"
DATADIR="$DIR/data"
SOCKET="$DIR/run/mysqld.sock"
PIDFILE="$DIR/run/mysqld.pid"
PORT=3307

status() {
  if [ -S "$SOCKET" ] && mysqladmin --socket="$SOCKET" -u root status >/dev/null 2>&1; then
    echo "RUNNING (socket $SOCKET, port $PORT)"
    return 0
  fi
  echo "STOPPED"
  return 1
}

start() {
  if status >/dev/null 2>&1; then
    echo "Deja pornit."
    return 0
  fi

  mkdir -p "$DATADIR" "$DIR/run"

  if [ ! -d "$DATADIR/mysql" ]; then
    echo "Inițializez datadir nou în $DATADIR ..."
    mysqld --initialize-insecure --datadir="$DATADIR" --log-error="$DIR/init.log"
  fi

  mysqld --datadir="$DATADIR" \
    --socket="$SOCKET" \
    --pid-file="$PIDFILE" \
    --port="$PORT" \
    --bind-address=127.0.0.1 \
    --log-error="$DIR/mysqld.log" \
    > "$DIR/mysqld.out" 2>&1 &
  disown

  for _ in $(seq 1 20); do
    sleep 0.5
    if status >/dev/null 2>&1; then
      echo "Pornit: $SOCKET (port $PORT)."
      return 0
    fi
  done

  echo "Nu a pornit în timp util — vezi $DIR/mysqld.log" >&2
  return 1
}

stop() {
  if [ -f "$PIDFILE" ]; then
    kill "$(cat "$PIDFILE")" 2>/dev/null || true
    echo "Oprit (pid $(cat "$PIDFILE"))."
  else
    echo "Nu rulează (fără pidfile)."
  fi
}

case "${1:-}" in
  start) start ;;
  stop) stop ;;
  status) status ;;
  *) echo "Utilizare: $0 {start|stop|status}" >&2; exit 1 ;;
esac
