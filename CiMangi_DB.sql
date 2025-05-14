CREATE DATABASE Cimangi;
USE Cimangi;
 
CREATE TABLE Categoria (
    ID INT(5) NOT NULL,
    Nome VARCHAR(20) NOT NULL,
    Principal_O_Secondario ENUM('principale', 'secondario') NOT NULL,
    PRIMARY KEY(ID)
);
 
CREATE TABLE Ristoranti(
    ID INT(5) NOT NULL,
    ID_Responsabile INT(5) NOT NULL,
    Nome VARCHAR(20) NOT NULL,
    Indirizzo VARCHAR(45) NOT NULL,
    Citta VARCHAR(20) NOT NULL,
    Ordinazioni_Aperte BOOL NOT NULL,
    PRIMARY KEY (ID),
    FOREIGN KEY (ID_Responsabile) REFERENCES Utenti(ID)
);
 
CREATE TABLE Utenti(
    ID INT(5) NOT NULL,
    Password VARCHAR(20) NOT NULL,
    ID_Ristorante INT(5),
    ID_Azienda INT(5),
    PRIMARY KEY (ID),
    FOREIGN KEY (ID_Ristorante) REFERENCES Ristoranti(ID),
    FOREIGN KEY (ID_Azienda) REFERENCES Azienda(ID)  -- Aggiunta FK
);
 
CREATE TABLE Pietanza(
    ID INT(5) NOT NULL,
    ID_Categoria INT(5) NOT NULL,
    Nome VARCHAR(20) NOT NULL,
    Prezzo REAL NOT NULL,
    Descrizione TEXT NOT NULL,
    Piatto_Del_Giorno BOOL NOT NULL,
    PRIMARY KEY(ID),
    FOREIGN KEY(ID_Categoria) REFERENCES Categoria(ID)
);
 
CREATE TABLE Ordine(
    ID INT(5) NOT NULL,
    ID_Dipendente INT(5) NOT NULL,
    Data_Inserimento DATE NOT NULL,
    Azienda_O_Ristorante ENUM('azienda', 'ristorante') NOT NULL,
    Dettagli_Ristorante VARCHAR(100) NOT NULL,
    Apertura_Ordinazioni TIME NOT NULL,
    Chiusura_Ordinazioni TIME NOT NULL,
    Commento TEXT NOT NULL,
    Annullato BOOL NOT NULL,
    Aperte_Automaticamente BOOL NOT NULL,
    Annullabile BOOL NOT NULL,
    PRIMARY KEY (ID),
    FOREIGN KEY (ID_Dipendente) REFERENCES Utenti(ID)  -- Riferimento diretto a Utenti
    -- Potresti aggiungere FK per Azienda_O_Ristorante se desideri una relazione dinamica
);
 
CREATE TABLE Azienda(
    ID INT(5) NOT NULL,
    ID_Responsabile INT(5) NOT NULL,
    Nome VARCHAR(20) NOT NULL,
    Indirizzo VARCHAR(45) NOT NULL,
    Citta VARCHAR(20) NOT NULL,
    PRIMARY KEY(ID),
    FOREIGN KEY (ID_Responsabile) REFERENCES Utenti(ID)
);
 
CREATE TABLE Dettagli_Convenzione(
    ID INT(5) NOT NULL,
    Max_Piatti_Principali INT(2) NOT NULL,
    Max_Piatti_Secondari INT(2) NOT NULL,
    Azienda_O_Ristorante BOOL NOT NULL,
    PRIMARY KEY (ID)
);
 
CREATE TABLE Token(
		Valore VARBINARY NOT NULL;
		PRIMARY KEY (Valore)
);