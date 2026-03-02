# Architecture Documentation - Hoodie Shop Refactoring

## Overview
This document describes the architecture and design decisions made during the professional refactoring of the Laravel e-commerce shop.

## Date: 2026-03-02

---

## Architecture Overview

```
┌─────────────────────────────────────────────────────────────────────┐
│                        Laravel Application                           │
├─────────────────────────────────────────────────────────────────────┤
│  ┌───────────────────────────────────────────────────────────────┐  │
│  │                      Modules Layer                            │  │
│  │  ┌─────────────────────────────────────────────────────────┐  │  │
│  │  │          app/Modules/Shop/                              │  │  │
│  │  │  ┌──────────┬────────────┬──────────────┬────────────┐  │  │  │
│  │  │  │ Components│  Services  │Repositories  │   DTOs     │  │  │  │
│  │  │  │  (Livewire│ (Business  │ (DB Access) │(Data       │  │  │  │
│  │  │  │   Volt)   │  Logic)    │              │ Transfer)  │  │  │  │
│  │  │  └──────────┴────────────┴──────────────┴────────────┘  │  │  │
│  │  └─────────────────────────────────────────────────────────┘  │  │
│  └───────────────────────────────────────────────────────────────┘  │
│  ┌───────────────────────────────────────────────────────────────┐  │
│  │                  View Layer (Blade + Volt)                    │  │
│  │  ┌──────────┬──────────┬──────────┬──────────┬────────────┐ │  │
│  │  │ProductCard│  Cart  │Checkout│  Layout  │  Components  │ │  │
│  │  │ (Volt)   │(Volt)  │ (Volt)  │(Blade)  │  (Blade)     │ │  │
│  │  └──────────┴──────────┴──────────┴──────────┴────────────┘ │  │
│  └───────────────────────────────────────────────────────────────┘  │
│  ┌───────────────────────────────────────────────────────────────┐  │
│  │                    Service Layer                              │  │
│  │  ┌──────────┬──────────┬──────────┬──────────┬────────────┐ │  │
│  │  │  Auth    │  Cart    │  Order   │  Product │   User     │ │  │
│  │  └──────────┴──────────┴──────────┴──────────┴────────────┘ │  │
│  └───────────────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────────────┘
```

---

## Design System

### Color Palette
The application uses a dark mode first approach with the following color system:

| Token | Hex | Usage |
|-------|-----|-------|
| dark-900 | #0F0F0F | Primary background |
| dark-800 | #1A1A1A | Secondary background (cards) |
| dark-700 | #262626 | Tertiary background (inputs) |
| dark-600 | #404040 | Borders, hover states |
| dark-500 | #525252 | Light borders |
| brand | #6366F1 | Primary brand color (Indigo) |
| brand-hover | #818CF8 | Brand hover state |
| success | #22C55E | Success states |
| error | #EF4444 | Error states |

### Typography
- **Font Family**: Inter (system-ui, sans-serif)
- **Type Scale**:
  - H1: 3.75rem (60px) / 700
  - H2: 2.25rem (36px) / 700
  - H3: 1.5rem (24px) / 600
  - H4: 1.25rem (20px) / 600
  - Body: 1rem (16px) / 400
  - Small: 0.875rem (14px) / 400
  - XSmall: 0.75rem (12px) / 500

### Components
1. **Buttons**
   - Primary: Transparent border, text on hover fill
   - Secondary: Dark background with hover
   - CTA: Brand color with shadow and lift effect

2. **Cards**
   - Background: dark-800
   - Border: dark-700 (dark-600 on hover)
   - Border Radius: 8px
   - Hover: scale(1.02), shadow

3. **Inputs**
   - Background: dark-700
   - Border: dark-600 (brand on focus)
   - Text: dark-100
   - Border Radius: 6px

---

## Modular Architecture

### Folder Structure
```
app/
├── Modules/
│   └── Shop/
│       ├── Components/
│       │   ├── ProductCard.php (Volt)
│       │   ├── Cart.php (Volt)
│       │   └── Checkout.php (Volt)
│       ├── Services/
│       │   ├── CartService.php
│       │   ├── OrderService.php
│       │   └── ProductService.php
│       ├── Repositories/
│       │   ├── ProductRepository.php
│       │   ├── CartRepository.php
│       │   └── OrderRepository.php
│       └── DTOs/
│           ├── ProductDTO.php
│           ├── CartItemDTO.php
│           └── OrderDTO.php
```

### Responsibility Separation

#### Components (Livewire/Volt)
- Single responsibility for UI components
- Handle user interactions
- Trigger business logic via services
- No direct database access

#### Services
- Encapsulate business logic
- Validate data
- Coordinate between repositories
- Implement domain rules

#### Repositories
- Abstract database operations
- No business logic
- Return DTOs or Eloquent models
- Support query building

#### DTOs (Data Transfer Objects)
- Strongly typed data structures
- Validate data on creation
- No business logic
- Immutable where possible

---

## Key Components

### ProductCard Component
**File**: `app/Livewire/Shop/ProductCard.php`

**Responsibilities**:
- Display product information
- Show product image with lazy loading
- Handle "Add to Cart" actions
- Display category badges
- Show stock status

**Features**:
- 4:5 aspect ratio
- Hover effects (scale, border color)
- Animated cart badge
- Lazy loading images

### Cart Component
**File**: `app/Livewire/Shop/Cart.php`

**Responsibilities**:
- Display cart items
- Update quantities
- Remove items
- Calculate totals
- Sync with session/DB

**Features**:
- Live updates without page reload
- Session support for guests
- Database sync for logged-in users
- Toast notifications

### Checkout Component
**File**: `app/Livewire/Shop/Checkout.php`

**Responsibilities**:
- Multi-step form validation
- Address collection
- Payment method selection
- Order creation
- Stock management

**Features**:
- Step-by-step progress
- Form validation
- Stock deduction
- Order history

---

## Styling Approach

### Tailwind CSS Configuration
- Custom dark color palette
- Brand colors
- Custom animations
- Extended spacing and border radius

### CSS Variables
```css
:root {
    --color-bg-primary: #0F0F0F;
    --color-bg-secondary: #1A1A1A;
    --color-bg-tertiary: #262626;
    --color-brand: #6366F1;
    --color-brand-hover: #818CF8;
    --color-success: #22C55E;
    --color-error: #EF4444;
}
```

### Component Classes
- `.btn-primary`, `.btn-secondary`, `.btn-cta`
- `.card`, `.card-product`
- `.input-default`, `.input-error`
- `.product-card`, `.category-card`
- `.filter-section`, `.sort-select`

---

## Responsive Design

### Breakpoints
| Breakpoint | Width | Usage |
|------------|-------|-------|
| sm | 640px | Mobile Landscape |
| md | 768px | Tablet |
| lg | 1024px | Desktop |
| xl | 1280px | Large Desktop |
| 2xl | 1536px | Extra Large |

### Grid System
- **Product Grid**: 1 col (mobile), 2 cols (tablet), 3 cols (desktop), 4 cols (xl)
- **Filter Sidebar**: Collapses on mobile
- **Product Card**: 4:5 aspect ratio

---

## Testing Strategy

### Automated Tests
- Unit tests for services
- Feature tests for components
- Integration tests for workflows
- JavaScript tests for interactions

### Manual Testing
- Mobile: 375px viewport
- Tablet: 768px viewport
- Desktop: 1280px viewport
- Dark mode verification

---

## Performance Optimizations

1. **Lazy Loading**: Images load when visible
2. **Code Splitting**: Vue components load on demand
3. **Caching**: Product data cached
4. **CDN**: Static assets served via CDN

---

## Migration Path

### From Old Architecture
1. **Extract Business Logic**: Move from controllers to services
2. **Create Repositories**: Abstract database access
3. **Convert Volt Components**: Replace controller views with Livewire
4. **Update Styling**: Apply dark theme consistently
5. **Add DTOs**: Type-safe data transfer

---

## Future Improvements

1. **SPA Integration**: Full Single Page Application
2. **GraphQL API**: Replace REST API
3. **Real-time Features**: WebSocket integration
4. **PWA Support**: Offline capability
5. **Micro-frontend**: Component sharing across apps

---

## Build Process

```bash
# Development
npm run dev

# Production
npm run build

# Tests
php artisan test

# Linting
npm run lint
```

---

## Deployment Checklist

- [ ] Run `npm run build`
- [ ] Run `php artisan migrate`
- [ ] Clear cache: `php artisan cache:clear`
- [ ] Optimize: `php artisan optimize`
- [ ] Run tests
- [ ] Verify dark mode
- [ ] Test responsive design
- [ ] Check build artifacts

---

## Notes

- Dark mode is the default theme
- No dark/light toggle required
- All components use consistent spacing
- Animations use 200-300ms transitions
- Focus states use brand color

---

*Last Updated: 2026-03-02*
