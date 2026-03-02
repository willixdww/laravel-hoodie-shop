# Laravel Hoodie & Jeans Shop

Ein moderner E-Commerce Shop basierend auf Laravel 12 mit Livewire Volt und Tailwind CSS.

## 🚀 Features

- **Moderne Technologien**: Laravel 12, Livewire Volt, Alpine.js, Tailwind CSS
- **Dark Mode**: Design-First Ansatz mit individuellem Farbschema
- **Produktkatalog**: Kategorien, Filter, Sortierung
- **Warenkorb**: Session-basiert für Gäste, DB-basiert für registrierte User
- **Checkout**: Adressformular, Zahlungsmethoden (PayPal, Kreditkarte, Rechnung)
- **Bestellverwaltung**: Bestellhistorie für eingeloggte User
- **Responsive Design**: Mobile-First Ansatz mit Tailwind CSS

## 📦 Database Schema

- **categories**: Kategorien (Hoodies, Jeans)
- **products**: Produkte mit Preis, Bild, Größen, Farben
- **carts**: Warenkorb-Positionen (session_id oder user_id)
- **orders**: Bestellungen mit Status und Zahlungsinformationen
- **order_items**: Bestellte Produkte mit Mengen und Preisen

## 🔧 Installation

```bash
# Repository klonen
git clone https://github.com/willixdww/laravel-hoodie-shop.git
cd hoodie-shop

# Abhängigkeiten installieren
composer install
npm install

# Umgebungsdatei kopieren
cp .env.example .env

# Application key generieren
php artisan key:generate

# Datenbank erstellen und seeden
php artisan migrate:fresh --seed

# Assets bauen
npm run build

# Server starten
php artisan serve
```

## 📊 Seed Data

- **2 Kategorien**: Hoodies, Jeans
- **12 Produkte**: 6 Hoodies, 6 Jeans mit unterschiedlichen Größen und Farben

## 🎨 Farbschema (Dark Mode)

- **Hintergrund**: `#0F0F0F`
- **Karten**: `#1A1A1A`
- **Primary**: `#6366F1` (Indigo)
- **Text**: `#F5F5F5`

## 🛠️ Tech Stack

- **Backend**: Laravel 12, Livewire Volt
- **Frontend**: Alpine.js, Tailwind CSS
- **Database**: SQLite (production-ready)
- **Build**: Vite

## 📝 Routes

| Route | Method | Description |
|-------|--------|-------------|
| `/` | GET | Homepage mit Hero und Featured Products |
| `/products/{product}` | GET | Produktdetailseite |
| `/cart` | GET | Warenkorb |
| `/cart/add` | POST | Produkt zum Warenkorb hinzufügen |
| `/cart/update` | POST | Warenkorb aktualisieren |
| `/cart/{id}` | DELETE | Produkt aus Warenkorb entfernen |
| `/checkout` | GET | Checkout-Formular |
| `/checkout/process` | POST | Bestellung abschließen |
| `/checkout/success/{order}` | GET | Bestellbestätigung |
| `/orders` | GET | Bestellhistorie |

## 📸 Screenshots

**Homepage:**
- Hero-Section mit Call-to-Action
- Featured Products Grid
- Kategorien-Übersicht

**Produktseite:**
- Produktbild
- Größen- und Farbauswahl
- Warenkorb-Button
- Produktinformationen

**Warenkorb:**
- Produkte mit Mengenänderung
- Preisberechnung
- Checkout-Button

## 🎯 Nächste Schritte

- [ ] Benutzeranmeldung/Registrierung vollständig integrieren
- [ ] PayPal-Integration für echte Zahlungen
- [ ] E-Mail-Bestätigungen
- [ ] Admin-Panel für Produktverwaltung
- [ ] Wunschliste/Favoriten
- [ ] Newsletter-Anmeldung

## 📄 Lizenz

MIT License

## 👤 Autor

**Sebastian**
- GitHub: [@willixdww](https://github.com/willixdww)
- Repository: [laravel-hoodie-shop](https://github.com/willixdww/laravel-hoodie-shop)

---

*Erstellt mit ❤️ für Premium Hoodies & Jeans*
