# Agent Core - Laravel Real Estate Management System

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Descrizione del Progetto

**Agent Core** è un gestionale immobiliare avanzato sviluppato con [Laravel 10](https://laravel.com). Il sistema è progettato per centralizzare le attività delle agenzie immobiliari, permettendo la gestione di proprietà, cantieri, contatti e integrazioni social da un'unica dashboard intuitiva.

## Funzionalità Principali

### 🏢 Gestione Multi-Agenzia
Il sistema supporta la gestione di diverse entità agenzia.
- **Creazione e Configurazione**: Gestione completa dei dati aziendali (nome, email, telefono, sito web, indirizzo).
- **Sicurezza e Accessi**: Middleware dedicato (`agency.canAccess`) per garantire la sicurezza dei dati e la corretta segregazione degli accessi tramite UUID.

### 🏠 Gestione Immobili (Properties)
Schede immobile dettagliate con un vasto set di attributi per coprire ogni esigenza descrittiva:
- **Dati Generali**: Contratto, tipologia, categoria, prezzo e spese condominiali.
- **Struttura**: Metratura, piani, numero locali/bagni, anno di costruzione.
- **Caratteristiche**: Box, ascensore, aria condizionata, giardino, terrazzo, lusso, ecc.
- **Efficienza Energetica**: Gestione APE, tipologia impianto riscaldamento e consumi.
- **Stato**: Occupazione, condizioni interne e arredamento.

### 🏗️ Cantieri e Nuove Costruzioni
Sezione dedicata (`ConstructionSiteController`) per la gestione di interi cantieri o sviluppi immobiliari complessi, separata dalle singole unità abitative.

### 🔄 Importazione e Automazione
- **RealSmart Import**: Integrazione per l'importazione automatica di proprietà tramite Cron Job e servizi dedicati.

### 👤 Utenti e Autenticazione
- Registrazione e Login completi.
- Verifica Email tramite token.
- Gestione profilo utente e cambio password.

## Requisiti Tecnici

Il progetto richiede le seguenti dipendenze:
- **PHP**: ^8.1
- **Laravel**: ^10.10
- **Database**: MySQL/MariaDB
- **Servizi Esterni**: Brevo (ex Sendinblue) per l'invio transazionale di email (`getbrevo/brevo-php`).

## Installazione

1. **Clona il repository**
   ```bash
   git clone [url-del-tuo-repo]