# Edmond Serenity

**Care Facility Management System**

A comprehensive Laravel + Filament application designed to streamline operations in assisted living and care facilities.

---

## Features

### For Administrators
- Resident management
- Staff management
- Medication database
- Facility/branch management
- Analytics and reporting
- Quality assurance dashboards
- Training and competency tracking

### For Caregivers
- Resident quick view cards
- Medication administration tracking
- Vitals monitoring (BP, pulse, temp, O2)
- Behavior charting (ADL, symptoms, triggers)
- Appointment scheduling
- Incident reporting
- Emergency protocol access
- Shift reports

### System Capabilities
- Role-based access control (Admin, Caregiver, Nurse)
- Real-time notifications and alerts
- Mobile-optimized interface
- Offline support with data synchronization
- Photo and documentation uploads
- Comprehensive audit trails

---

## Technology Stack

- **Framework:** Laravel 10+
- **Admin Panel:** Filament 3.x
- **Database:** MySQL/PostgreSQL
- **Authentication:** Laravel Sanctum
- **Real-time:** Laravel Echo + Pusher
- **Frontend:** Livewire + Alpine.js (via Filament)
- **Mobile:** Progressive Web App (PWA)

---

## Project Status

🚧 **In Development** - Sprint 1 (Core System Setup)

See [PROJECT_PLAN.md](PROJECT_PLAN.md) for detailed task list and sprint breakdown.

---

## Installation

```bash
# Clone the repository
git clone <repository-url>
cd family-home

# Install dependencies
composer install
npm install

# Configure environment
cp .env.example .env
php artisan key:generate

# Set up database
php artisan migrate
php artisan db:seed

# Install Filament
php artisan filament:install

# Build assets
npm run build

# Start development server
php artisan serve
```

---

## Development Timeline

- **Sprint 1-2:** Core system setup (Weeks 1-2)
- **Sprint 3-4:** Admin dashboard & CRUD (Weeks 3-4)
- **Sprint 5-6:** Caregiver dashboard Phase 1 (Weeks 5-6)
- **Sprint 7-8:** Caregiver dashboard Phase 2 (Weeks 7-8)
- **Sprint 9-10:** Mobile optimization (Weeks 9-10)
- **Sprint 11-12:** Analytics & reporting (Weeks 11-12)
- **Sprint 13:** Notifications (Week 13)
- **Sprint 14-15:** Testing & deployment (Weeks 14-15)

---

## Key Deliverables

1. Admin dashboard with comprehensive management tools
2. Caregiver dashboard with medication, vitals, and behavior tracking
3. Mobile-ready interface with offline capability
4. Real-time notifications and alerts
5. QA dashboards and performance tracking
6. Training materials and documentation

---

## Contributing

This is a private project for care facility management. For questions or contributions, contact the project administrator.

---

## License

Proprietary - All rights reserved

---

## Support

For technical support or feature requests, please contact the development team.

