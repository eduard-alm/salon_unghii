CREATE TABLE programari (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    nume          VARCHAR(100)  NOT NULL,
    telefon       VARCHAR(20)   NOT NULL,
    serviciu      VARCHAR(80)   NOT NULL,
    data_dorita   DATE          NOT NULL,
    ora_dorita    VARCHAR(20)   NOT NULL,
    mesaj         TEXT          NULL,
    status        ENUM('noua','confirmata','anulata') DEFAULT 'noua',
    creat_la      DATETIME      DEFAULT CURRENT_TIMESTAMP,
    ip            VARCHAR(45)   NULL,

    INDEX idx_data (data_dorita),
    INDEX idx_status (status)
);
