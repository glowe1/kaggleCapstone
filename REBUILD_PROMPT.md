# Healthcare Management System - Complete Rebuild Prompt

## Project Overview
Build a comprehensive healthcare management system for assisted living facilities using Laravel 12 and Filament 3.2. The system should manage residents, staff, medications, appointments, assessments, vital signs, and more with role-based access control.

## Technology Stack
- **Backend**: Laravel 12.x with PHP 8.2+
- **Admin Panel**: Filament 3.2
- **Database**: MySQL/PostgreSQL
- **Frontend**: Blade templates with Tailwind CSS
- **Authentication**: Laravel's built-in authentication with role-based permissions

## Core Features & Modules

### 1. User Management & Authentication
- **User Roles**: `super_admin`, `administrator`, `clinical_supervisor`, `caregiver`, `family_member`
- **Staff Management**: Complete staff profiles with credentials, positions, and branch assignments
- **Role-Based Access Control**: Granular permissions for different user types
- **Dashboard Routing**: Different dashboards for admins vs caregivers

### 2. Organization Structure
- **Facilities**: Parent organizations
- **Branches**: Individual care homes with staff assignments
- **Hierarchical Management**: Facility → Branch → Residents → Caregivers

### 3. Resident Management
- **Resident Profiles**: Complete demographic and medical information
- **Document Storage**: Resident documents and files
- **Caregiver Assignments**: Assign specific caregivers to residents
- **Resident Manager**: Advanced resident management with filtering and assignment tools

### 4. Medication System
- **Drug Database**: Comprehensive drug/medicine database with details
- **Medication Prescriptions**: Resident-specific medication prescriptions
- **Medication Administration Records (MAR)**: Track when medications are given
- **Dynamic Time Fields**: Time pickers based on medication instructions (e.g., "Thrice daily" = 3 time fields)
- **Branch Filtering**: Filter residents by branch when administering medications

### 5. Vital Signs Management
- **Vital Signs Recording**: Blood pressure, temperature, pulse, weight, etc.
- **Vital Ranges**: Set normal/warning/critical ranges for each vital sign
- **Trend Analysis**: Track vital sign trends over time
- **Automated Alerts**: Alert when vitals are outside normal ranges

### 6. Appointment System
- **Healthcare Provider Directory**: Manage doctors, specialists, etc.
- **Appointment Scheduling**: Book appointments for residents
- **Appointment History**: Track appointment history with filtering
- **Custom Appointment Pages**: Card-based appointment management

### 7. Assessment System
- **Assessment Creation**: Create comprehensive resident assessments
- **Assessment Sections**: Organize questions into categories
- **Progress Tracking**: Track completion percentage of assessments
- **Assessment History**: View and manage assessment records

### 8. Behavior Tracking
- **Behavior Categories**: ADL, Behavioral, Medical, Safety categories
- **Behavior Logging**: Record behavior occurrences
- **Behavior Charts**: Visualize behavior patterns

### 9. Sleep Monitoring
- **Sleep Records**: Track individual sleep sessions
- **Sleep Patterns**: Monthly sleep pattern aggregations
- **Sleep Heatmaps**: 24-hour sleep data visualization

### 10. Incident Management
- **Incident Reports**: Comprehensive incident tracking
- **Incident Categories**: Categorize different types of incidents
- **Follow-up Tracking**: Track incident resolution

### 11. Staff Management
- **Leave Requests**: Time-off management for staff
- **Caregiver Assignments**: Shift and resident assignments
- **Task Management**: Assign and track tasks

## Database Schema

### Core Tables (28 total)
```sql
-- Authentication & Security
users, password_reset_tokens, personal_access_tokens

-- Organization Structure  
facilities, branches

-- Resident Management
residents, resident_documents

-- Medication System
drugs, medications, medication_administrations

-- Vital Signs
vital_signs, vital_ranges

-- Appointments
healthcare_providers, appointments

-- Behavior Tracking
behavior_categories, behaviors, behavior_charts

-- Sleep Monitoring
sleep_records, sleep_patterns, sleep_hourly_data

-- Assessments
assessments, assessment_sections, assessment_questions

-- Incident Management
incident_reports

-- Staff Management
leave_requests, caregiver_assignments

-- Communication
communications, tasks

-- System & Analytics
charts, audit_logs
```

## Filament Resources & Pages

### Resources (CRUD Interfaces)
- **UserResource**: Staff management with role-based permissions
- **ResidentResource**: Resident profiles and management
- **MedicationResource**: Medication prescriptions with drug selection
- **MedicationAdministrationResource**: MAR with branch filtering
- **DrugResource**: Drug database management
- **VitalSignResource**: Vital signs recording
- **VitalRangeResource**: Vital ranges configuration
- **AppointmentResource**: Appointment scheduling
- **AssessmentResource**: Assessment management
- **BranchResource**: Branch management
- **FacilityResource**: Facility management
- **LeaveRequestResource**: Leave request management
- **RoleResource**: Role and permission management

### Custom Pages
- **Dashboard**: Role-based dashboard routing
- **AdminDashboard**: Admin-specific dashboard with statistics
- **CaregiverDashboard**: Caregiver-specific dashboard
- **MedicationManagement**: Medication management dashboard
- **CustomAppointments**: Card-based appointment management
- **ResidentAppointments**: Resident-specific appointment pages
- **AppointmentHistory**: Appointment history with filtering
- **AssessmentDashboard**: Assessment management dashboard
- **AssessmentForm**: Dynamic assessment forms
- **ViewVitals**: Vital signs viewing with charts
- **ResidentManager**: Advanced resident management

## Navigation Structure

### Admin Navigation
- **Dashboard**: Role-based dashboard
- **Residents**: Resident management
- **Resident Manager**: Advanced resident management
- **Vital Signs**: Vital signs management
- **Assessments**: Assessment management
- **Appointments**: Appointment management
- **Medications**: Medication management
- **Staff**: User management, roles, leave requests
- **System Administration**: Branches, facilities, users, residents

### Caregiver Navigation
- **Dashboard**: Caregiver dashboard
- **Residents**: View assigned residents
- **Vital Signs**: Record vital signs
- **Assessments**: Complete assessments
- **Appointments**: View appointments
- **Medications**: Medication administration
- **Leave Requests**: Personal leave management

## Key Features & Functionality

### 1. Role-Based Access Control
- **Permission System**: Granular permissions for each resource
- **Navigation Filtering**: Show/hide navigation items based on role
- **Data Filtering**: Filter data based on user permissions
- **Dashboard Routing**: Different dashboards for different roles

### 2. Dynamic Forms
- **Cascading Dropdowns**: Branch → Resident → Medication filtering
- **Dynamic Fields**: Time pickers based on medication instructions
- **Form Validation**: Comprehensive validation rules
- **Pre-filled Data**: Auto-populate forms with relevant data

### 3. Data Visualization
- **Charts**: Vital signs trends, assessment progress
- **Statistics**: Dashboard statistics and metrics
- **Reports**: Various reporting capabilities
- **Export**: Data export functionality

### 4. User Experience
- **Responsive Design**: Mobile-friendly interface
- **Custom Styling**: Kuban card style and custom designs
- **Intuitive Navigation**: Clear navigation structure
- **Search & Filtering**: Advanced search and filtering capabilities

## Implementation Requirements

### 1. Database Setup
- Create all 28 database tables with proper relationships
- Set up foreign key constraints
- Create indexes for performance
- Seed initial data (roles, permissions, sample data)

### 2. Authentication & Authorization
- Implement role-based authentication
- Create permission system
- Set up middleware for access control
- Configure user registration and login

### 3. Filament Configuration
- Set up Filament panel
- Configure resources and pages
- Set up navigation groups
- Configure permissions and access control

### 4. Custom Components
- Create custom dashboard pages
- Implement role-based routing
- Set up custom forms and tables
- Configure dynamic field behavior

### 5. Styling & UI
- Implement custom CSS for Kuban card style
- Set up responsive design
- Configure Tailwind CSS
- Create custom Blade templates

## Sample Data & Seeding
- **Users**: Admin, caregivers, clinical supervisors
- **Facilities & Branches**: Sample care homes
- **Residents**: Sample resident profiles
- **Drugs**: Common medications database
- **Vital Ranges**: Standard vital sign ranges
- **Roles & Permissions**: Complete permission system

## Security Considerations
- **Data Encryption**: Sensitive data encryption
- **Access Control**: Role-based access to sensitive information
- **Audit Logging**: Track all system changes
- **Data Privacy**: HIPAA compliance considerations
- **Backup & Recovery**: Regular data backups

## Performance Requirements
- **Database Optimization**: Proper indexing and query optimization
- **Caching**: Implement appropriate caching strategies
- **Lazy Loading**: Optimize resource loading
- **Pagination**: Efficient data pagination

## Testing Requirements
- **Unit Tests**: Test individual components
- **Integration Tests**: Test system integration
- **Feature Tests**: Test complete user workflows
- **Security Tests**: Test access control and permissions

## Deployment Considerations
- **Environment Configuration**: Proper environment setup
- **Database Migration**: Smooth database updates
- **Asset Compilation**: Frontend asset optimization
- **Monitoring**: System health monitoring

This system should provide a comprehensive solution for managing assisted living facilities with proper role-based access, intuitive user interface, and robust data management capabilities.








