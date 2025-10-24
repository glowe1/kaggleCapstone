# 🗄️ Edmond Serenity AFH - Complete Database Schema

## 📊 DATABASE OVERVIEW

```sql
-- Core System Tables
CREATE DATABASE edmond_serenity_afh;
USE edmond_serenity_afh;
```

## 👥 USER & AUTHENTICATION TABLES

```sql
-- Users table for all staff members
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    first_name VARCHAR(255) NOT NULL,
    middle_names VARCHAR(255) NULL,
    last_name VARCHAR(255) NOT NULL,
    phone_number VARCHAR(20) NULL,
    date_of_birth DATE NULL,
    marital_status ENUM('single', 'married', 'divorced', 'widowed', 'separated') NULL,
    sex ENUM('male', 'female', 'other') NULL,
    position VARCHAR(255) NULL, -- Caregiver, Nurse, Supervisor, etc.
    credentials TEXT NULL,
    credential_details VARCHAR(255) NULL,
    date_employed DATE NULL,
    supervisor_name VARCHAR(255) NULL,
    provider_name VARCHAR(255) NULL,
    role ENUM('super_admin', 'administrator', 'clinical_supervisor', 'caregiver', 'family_member') DEFAULT 'caregiver',
    status ENUM('active', 'inactive', 'pending') DEFAULT 'pending',
    last_login_at TIMESTAMP NULL,
    profile_image VARCHAR(255) NULL,
    notes TEXT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL
);

-- Password reset table
CREATE TABLE password_reset_tokens (
    email VARCHAR(255) PRIMARY KEY,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL
);

-- Personal access tokens for API
CREATE TABLE personal_access_tokens (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tokenable_type VARCHAR(255) NOT NULL,
    tokenable_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    token VARCHAR(64) UNIQUE NOT NULL,
    abilities TEXT NULL,
    last_used_at TIMESTAMP NULL,
    expires_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

## 🏢 FACILITY & BRANCH MANAGEMENT

```sql
-- Facilities (parent organizations)
CREATE TABLE facilities (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    address TEXT NOT NULL,
    contact_email VARCHAR(255) NULL,
    phone VARCHAR(20) NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL
);

-- Branches (individual care homes)
CREATE TABLE branches (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    facility_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    address TEXT NOT NULL,
    phone VARCHAR(20) NOT NULL,
    fax VARCHAR(20) NULL,
    email VARCHAR(255) NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (facility_id) REFERENCES facilities(id) ON DELETE CASCADE
);
```

## 👴 RESIDENT MANAGEMENT

```sql
-- Main residents table
CREATE TABLE residents (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    branch_id BIGINT UNSIGNED NOT NULL,
    first_name VARCHAR(255) NOT NULL,
    middle_names VARCHAR(255) NULL,
    last_name VARCHAR(255) NOT NULL,
    date_of_birth DATE NOT NULL,
    diagnosis TEXT NULL,
    allergies TEXT NULL,
    physician_name VARCHAR(255) NULL,
    pep_or_doctor VARCHAR(255) NULL,
    room VARCHAR(50) NOT NULL,
    cart VARCHAR(50) NULL,
    profile_image VARCHAR(255) NULL,
    emergency_contact_name VARCHAR(255) NULL,
    emergency_contact_phone VARCHAR(20) NULL,
    emergency_contact_relationship VARCHAR(100) NULL,
    insurance_provider VARCHAR(255) NULL,
    insurance_policy_number VARCHAR(100) NULL,
    status ENUM('active', 'inactive', 'discharged') DEFAULT 'active',
    admission_date DATE NULL,
    discharge_date DATE NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (branch_id) REFERENCES branches(id) ON DELETE CASCADE
);

-- Resident documents and files
CREATE TABLE resident_documents (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    resident_id BIGINT UNSIGNED NOT NULL,
    document_type ENUM('insurance', 'medical', 'legal', 'other') NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    file_size INT NULL,
    uploaded_by BIGINT UNSIGNED NOT NULL,
    notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (resident_id) REFERENCES residents(id) ON DELETE CASCADE,
    FOREIGN KEY (uploaded_by) REFERENCES users(id)
);
```

## 💊 MEDICATION MANAGEMENT

```sql
-- Medication master list
CREATE TABLE medications (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    medication_code VARCHAR(100) NULL,
    equivalent_to VARCHAR(255) NULL,
    instructions TEXT NULL,
    default_quantity VARCHAR(100) NULL,
    diagnosis TEXT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Resident medication prescriptions
CREATE TABLE resident_medications (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    resident_id BIGINT UNSIGNED NOT NULL,
    medication_id BIGINT UNSIGNED NOT NULL,
    instructions ENUM('t.i.d', 'q.i.d', 'b.i.d', 'PRN', 'h.s', 'a.m', 'p.m') NOT NULL,
    quantity VARCHAR(100) NOT NULL,
    diagnosis TEXT NULL,
    medication_time TIME NULL,
    start_date DATE NOT NULL,
    end_date DATE NULL,
    status ENUM('active', 'inactive', 'completed') DEFAULT 'active',
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (resident_id) REFERENCES residents(id) ON DELETE CASCADE,
    FOREIGN KEY (medication_id) REFERENCES medications(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Medication administration records
CREATE TABLE medication_administrations (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    resident_medication_id BIGINT UNSIGNED NOT NULL,
    administered_by BIGINT UNSIGNED NOT NULL,
    administration_time TIMESTAMP NOT NULL,
    dosage VARCHAR(100) NOT NULL,
    route ENUM('oral', 'injection', 'topical', 'other') DEFAULT 'oral',
    status ENUM('administered', 'missed', 'refused', 'held') DEFAULT 'administered',
    notes TEXT NULL,
    verified_by BIGINT UNSIGNED NULL,
    verification_time TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (resident_medication_id) REFERENCES resident_medications(id) ON DELETE CASCADE,
    FOREIGN KEY (administered_by) REFERENCES users(id),
    FOREIGN KEY (verified_by) REFERENCES users(id)
);
```

## ❤️ VITAL SIGNS MANAGEMENT

```sql
-- Vital signs recordings
CREATE TABLE vital_signs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    resident_id BIGINT UNSIGNED NOT NULL,
    branch_id BIGINT UNSIGNED NOT NULL,
    measurement_date DATE NOT NULL,
    systolic INT NULL,
    diastolic INT NULL,
    temperature DECIMAL(4,2) NULL,
    pulse INT NULL,
    oxygen_saturation INT NULL,
    pain_level INT NULL CHECK (pain_level >= 0 AND pain_level <= 10),
    pain_description TEXT NULL,
    reason_declined TEXT NULL,
    status ENUM('approved', 'pending_review', 'declined', 'critical') DEFAULT 'approved',
    notes TEXT NULL,
    taken_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (resident_id) REFERENCES residents(id) ON DELETE CASCADE,
    FOREIGN KEY (branch_id) REFERENCES branches(id),
    FOREIGN KEY (taken_by) REFERENCES users(id)
);

-- Normal ranges configuration
CREATE TABLE vital_ranges (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    parameter ENUM('systolic', 'diastolic', 'temperature', 'pulse', 'oxygen_saturation') NOT NULL,
    min_normal DECIMAL(8,2) NOT NULL,
    max_normal DECIMAL(8,2) NOT NULL,
    min_warning DECIMAL(8,2) NULL,
    max_warning DECIMAL(8,2) NULL,
    min_critical DECIMAL(8,2) NULL,
    max_critical DECIMAL(8,2) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

## 📅 APPOINTMENT MANAGEMENT

```sql
-- Healthcare providers
CREATE TABLE healthcare_providers (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    specialty VARCHAR(255) NULL,
    contact_phone VARCHAR(20) NULL,
    contact_email VARCHAR(255) NULL,
    address TEXT NULL,
    notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Resident appointments
CREATE TABLE appointments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    resident_id BIGINT UNSIGNED NOT NULL,
    branch_id BIGINT UNSIGNED NOT NULL,
    provider_id BIGINT UNSIGNED NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NULL,
    type ENUM('clinician', 'counsellor', 'primary_care', 'specialist', 'dental', 'vision', 'therapy', 'other') NOT NULL,
    location ENUM('in_house', 'external') DEFAULT 'external',
    provider_name VARCHAR(255) NULL,
    description TEXT NULL,
    status ENUM('scheduled', 'confirmed', 'in_progress', 'completed', 'cancelled', 'no_show') DEFAULT 'scheduled',
    next_appointment_date DATE NULL,
    recurrence_pattern ENUM('one_time', 'daily', 'weekly', 'bi_weekly', 'monthly', 'custom') DEFAULT 'one_time',
    notes TEXT NULL,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (resident_id) REFERENCES residents(id) ON DELETE CASCADE,
    FOREIGN KEY (branch_id) REFERENCES branches(id),
    FOREIGN KEY (provider_id) REFERENCES healthcare_providers(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
);
```

## 🧠 BEHAVIOR MANAGEMENT

```sql
-- Behavior categories
CREATE TABLE behavior_categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    color_code VARCHAR(7) NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Individual behaviors
CREATE TABLE behaviors (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES behavior_categories(id) ON DELETE CASCADE
);

-- Behavior chart records
CREATE TABLE behavior_charts (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    resident_id BIGINT UNSIGNED NOT NULL,
    behavior_id BIGINT UNSIGNED NOT NULL,
    chart_date DATE NOT NULL,
    occurrence_time TIME NULL,
    severity ENUM('low', 'medium', 'high', 'critical') DEFAULT 'medium',
    triggers TEXT NULL,
    caregiver_intervention TEXT NULL,
    reported_to_provider BOOLEAN DEFAULT FALSE,
    provider_notes TEXT NULL,
    outcome TEXT NULL,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (resident_id) REFERENCES residents(id) ON DELETE CASCADE,
    FOREIGN KEY (behavior_id) REFERENCES behaviors(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
);
```

## 😴 SLEEP PATTERN MANAGEMENT

```sql
-- Individual sleep records
CREATE TABLE sleep_records (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    resident_id BIGINT UNSIGNED NOT NULL,
    branch_id BIGINT UNSIGNED NOT NULL,
    sleep_date DATE NOT NULL,
    sleep_time TIME NOT NULL,
    wake_time TIME NOT NULL,
    total_sleep_hours DECIMAL(4,2) NOT NULL,
    sleep_quality INT NULL CHECK (sleep_quality >= 1 AND sleep_quality <= 10),
    restlessness_episodes INT DEFAULT 0,
    notes TEXT NULL,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (resident_id) REFERENCES residents(id) ON DELETE CASCADE,
    FOREIGN KEY (branch_id) REFERENCES branches(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Aggregated sleep patterns
CREATE TABLE sleep_patterns (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    resident_id BIGINT UNSIGNED NOT NULL,
    month INT NOT NULL,
    year INT NOT NULL,
    total_sleep_hours DECIMAL(8,2) NOT NULL,
    total_awake_hours DECIMAL(8,2) NOT NULL,
    avg_sleep_hours DECIMAL(4,2) NOT NULL,
    days_with_records INT NOT NULL,
    common_sleep_time TIME NULL,
    common_wake_time TIME NULL,
    sleep_quality_score INT NULL,
    key_observations TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_resident_month_year (resident_id, month, year),
    FOREIGN KEY (resident_id) REFERENCES residents(id) ON DELETE CASCADE
);

-- Hourly sleep distribution for heatmaps
CREATE TABLE sleep_hourly_data (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sleep_pattern_id BIGINT UNSIGNED NOT NULL,
    hour_00 DECIMAL(3,2) DEFAULT 0,
    hour_01 DECIMAL(3,2) DEFAULT 0,
    hour_02 DECIMAL(3,2) DEFAULT 0,
    hour_03 DECIMAL(3,2) DEFAULT 0,
    hour_04 DECIMAL(3,2) DEFAULT 0,
    hour_05 DECIMAL(3,2) DEFAULT 0,
    hour_06 DECIMAL(3,2) DEFAULT 0,
    hour_07 DECIMAL(3,2) DEFAULT 0,
    hour_08 DECIMAL(3,2) DEFAULT 0,
    hour_09 DECIMAL(3,2) DEFAULT 0,
    hour_10 DECIMAL(3,2) DEFAULT 0,
    hour_11 DECIMAL(3,2) DEFAULT 0,
    hour_12 DECIMAL(3,2) DEFAULT 0,
    hour_13 DECIMAL(3,2) DEFAULT 0,
    hour_14 DECIMAL(3,2) DEFAULT 0,
    hour_15 DECIMAL(3,2) DEFAULT 0,
    hour_16 DECIMAL(3,2) DEFAULT 0,
    hour_17 DECIMAL(3,2) DEFAULT 0,
    hour_18 DECIMAL(3,2) DEFAULT 0,
    hour_19 DECIMAL(3,2) DEFAULT 0,
    hour_20 DECIMAL(3,2) DEFAULT 0,
    hour_21 DECIMAL(3,2) DEFAULT 0,
    hour_22 DECIMAL(3,2) DEFAULT 0,
    hour_23 DECIMAL(3,2) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (sleep_pattern_id) REFERENCES sleep_patterns(id) ON DELETE CASCADE
);
```

## 📝 ASSESSMENT MANAGEMENT

```sql
-- Assessment records
CREATE TABLE assessments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    resident_id BIGINT UNSIGNED NOT NULL,
    branch_id BIGINT UNSIGNED NOT NULL,
    assessment_type ENUM('initial', 'periodic', 'focused', 'discharge') NOT NULL,
    assessment_date DATE NOT NULL,
    assessor_id BIGINT UNSIGNED NOT NULL,
    status ENUM('draft', 'submitted', 'reviewed', 'approved', 'archived') DEFAULT 'draft',
    overall_score DECIMAL(5,2) NULL,
    recommendations TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (resident_id) REFERENCES residents(id) ON DELETE CASCADE,
    FOREIGN KEY (branch_id) REFERENCES branches(id),
    FOREIGN KEY (assessor_id) REFERENCES users(id)
);

-- Assessment sections
CREATE TABLE assessment_sections (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    assessment_id BIGINT UNSIGNED NOT NULL,
    section_type ENUM('demographic', 'medical_history', 'functional', 'cognitive', 'behavioral', 'nutritional', 'environmental', 'risk') NOT NULL,
    score DECIMAL(5,2) NULL,
    notes TEXT NULL,
    completed_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (assessment_id) REFERENCES assessments(id) ON DELETE CASCADE
);

-- Assessment questions and responses
CREATE TABLE assessment_questions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    section_id BIGINT UNSIGNED NOT NULL,
    question_text TEXT NOT NULL,
    response_type ENUM('text', 'number', 'select', 'checkbox', 'scale') NOT NULL,
    response_value TEXT NULL,
    notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (section_id) REFERENCES assessment_sections(id) ON DELETE CASCADE
);
```

## 🚨 INCIDENT MANAGEMENT

```sql
-- Incident reports
CREATE TABLE incident_reports (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    type ENUM('technical', 'behavior_chart', 'medical', 'safety', 'administrative', 'resident_care', 'facility', 'custom') NOT NULL,
    custom_type VARCHAR(100) NULL,
    priority ENUM('critical', 'high', 'medium', 'low') DEFAULT 'medium',
    status ENUM('open', 'in_progress', 'resolved', 'closed', 'on_hold') DEFAULT 'open',
    raised_by BIGINT UNSIGNED NOT NULL,
    assigned_to BIGINT UNSIGNED NULL,
    resident_id BIGINT UNSIGNED NULL,
    location VARCHAR(255) NULL,
    resolution_notes TEXT NULL,
    resolved_at TIMESTAMP NULL,
    approved_by BIGINT UNSIGNED NULL,
    approved_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (raised_by) REFERENCES users(id),
    FOREIGN KEY (assigned_to) REFERENCES users(id),
    FOREIGN KEY (resident_id) REFERENCES residents(id) ON DELETE SET NULL,
    FOREIGN KEY (approved_by) REFERENCES users(id)
);
```

## 👥 STAFF & LEAVE MANAGEMENT

```sql
-- Leave requests
CREATE TABLE leave_requests (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    staff_id BIGINT UNSIGNED NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    reason TEXT NOT NULL,
    status ENUM('pending', 'approved', 'declined') DEFAULT 'pending',
    decline_reason TEXT NULL,
    approved_by BIGINT UNSIGNED NULL,
    approved_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (staff_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (approved_by) REFERENCES users(id)
);

-- Staff assignments (caregiver to resident)
CREATE TABLE caregiver_assignments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    caregiver_id BIGINT UNSIGNED NOT NULL,
    resident_id BIGINT UNSIGNED NOT NULL,
    branch_id BIGINT UNSIGNED NOT NULL,
    assignment_date DATE NOT NULL,
    shift ENUM('morning', 'evening', 'night', 'full_day') NOT NULL,
    status ENUM('active', 'completed', 'cancelled') DEFAULT 'active',
    notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (caregiver_id) REFERENCES users(id),
    FOREIGN KEY (resident_id) REFERENCES residents(id) ON DELETE CASCADE,
    FOREIGN KEY (branch_id) REFERENCES branches(id)
);
```

## 💬 COMMUNICATION & UPDATES

```sql
-- Internal communications
CREATE TABLE communications (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    type ENUM('shift_report', 'clinical_update', 'announcement', 'emergency_alert', 'task_reminder') NOT NULL,
    priority ENUM('low', 'medium', 'high', 'critical') DEFAULT 'medium',
    sender_id BIGINT UNSIGNED NOT NULL,
    recipient_id BIGINT UNSIGNED NULL, -- NULL for broadcast messages
    is_broadcast BOOLEAN DEFAULT FALSE,
    requires_acknowledgment BOOLEAN DEFAULT FALSE,
    acknowledged_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES users(id),
    FOREIGN KEY (recipient_id) REFERENCES users(id)
);

-- Task assignments
CREATE TABLE tasks (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    assigned_to BIGINT UNSIGNED NOT NULL,
    assigned_by BIGINT UNSIGNED NOT NULL,
    due_date DATE NULL,
    due_time TIME NULL,
    priority ENUM('low', 'medium', 'high', 'critical') DEFAULT 'medium',
    status ENUM('pending', 'in_progress', 'completed', 'cancelled') DEFAULT 'pending',
    completed_at TIMESTAMP NULL,
    notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (assigned_to) REFERENCES users(id),
    FOREIGN KEY (assigned_by) REFERENCES users(id)
);
```

## 📈 CHARTS & ANALYTICS

```sql
-- Chart configurations
CREATE TABLE charts (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(100) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    data_source VARCHAR(255) NOT NULL,
    configuration JSON NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Audit logs for compliance
CREATE TABLE audit_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    action VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    model_type VARCHAR(255) NULL,
    model_id BIGINT UNSIGNED NULL,
    old_values JSON NULL,
    new_values JSON NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);
```

## 🔑 INDEXES FOR PERFORMANCE

```sql
-- User indexes
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_role ON users(role);
CREATE INDEX idx_users_status ON users(status);

-- Resident indexes
CREATE INDEX idx_residents_branch_id ON residents(branch_id);
CREATE INDEX idx_residents_status ON residents(status);
CREATE INDEX idx_residents_last_name ON residents(last_name);

-- Medication indexes
CREATE INDEX idx_medication_administrations_resident ON medication_administrations(resident_medication_id);
CREATE INDEX idx_medication_administrations_time ON medication_administrations(administration_time);

-- Vital signs indexes
CREATE INDEX idx_vital_signs_resident_date ON vital_signs(resident_id, measurement_date);
CREATE INDEX idx_vital_signs_status ON vital_signs(status);

-- Appointment indexes
CREATE INDEX idx_appointments_resident_date ON appointments(resident_id, appointment_date);
CREATE INDEX idx_appointments_status ON appointments(status);

-- Behavior chart indexes
CREATE INDEX idx_behavior_charts_resident_date ON behavior_charts(resident_id, chart_date);
CREATE INDEX idx_behavior_charts_behavior ON behavior_charts(behavior_id);

-- Sleep record indexes
CREATE INDEX idx_sleep_records_resident_date ON sleep_records(resident_id, sleep_date);

-- Incident report indexes
CREATE INDEX idx_incident_reports_status_priority ON incident_reports(status, priority);
CREATE INDEX idx_incident_reports_raised_by ON incident_reports(raised_by);

-- Leave request indexes
CREATE INDEX idx_leave_requests_staff_status ON leave_requests(staff_id, status);
CREATE INDEX idx_leave_requests_dates ON leave_requests(start_date, end_date);
```

## 📊 INITIAL DATA SEEDING

```sql
-- Insert default behavior categories
INSERT INTO behavior_categories (name, description, color_code) VALUES
('Activities of Daily Living', 'Basic self-care activities', '#3B82F6'),
('Behavioral Symptoms', 'Emotional and behavioral indicators', '#EF4444'),
('Medical Indicators', 'Health-related symptoms and signs', '#10B981'),
('Safety Concerns', 'Safety-related behaviors and incidents', '#F59E0B');

-- Insert common behaviors
INSERT INTO behaviors (category_id, name, description) VALUES
(1, 'Meals', 'Eating and drinking activities'),
(1, 'Shower', 'Bathing and personal hygiene'),
(1, 'Grooming', 'Personal care and appearance'),
(1, 'Medication', 'Medication administration'),
(1, 'Log in and out', 'Check-in/check-out tracking'),
(2, 'Anxiety', 'Signs of anxiety or nervousness'),
(2, 'Agitation', 'Restlessness or irritability'),
(2, 'Threatening or intimidation', 'Verbal or physical threats'),
(3, 'Blood sugar low', 'Hypoglycemia symptoms'),
(3, 'Blood sugar high', 'Hyperglycemia symptoms'),
(3, 'Sick / 911 call', 'Medical emergency situations');

-- Insert default vital ranges
INSERT INTO vital_ranges (parameter, min_normal, max_normal, min_warning, max_warning, min_critical, max_critical) VALUES
('systolic', 90, 120, 80, 139, 70, 180),
('diastolic', 60, 80, 50, 89, 40, 120),
('temperature', 97.7, 99.5, 96.0, 100.4, 95.0, 104.0),
('pulse', 60, 100, 50, 110, 40, 140),
('oxygen_saturation', 95, 100, 90, 94, 85, 100);
```

## 🎯 DATABASE SUMMARY

**Total Tables:** 28 core tables

**Key Relationships:**
- Facilities → Branches → Residents (hierarchy)
- Users → Multiple functional areas (staff management)
- Residents → Clinical data (medications, vitals, behaviors, sleep)
- Comprehensive audit trail throughout

**Security Features:**
- Soft deletes on critical tables
- Foreign key constraints for data integrity
- Audit logging for compliance
- Indexed for performance with large datasets

**Medication Instruction Abbreviations:**
- `t.i.d` - Three times a day
- `q.i.d` - Four times a day
- `b.i.d` - Twice a day
- `PRN` - As needed
- `h.s` - At bedtime
- `a.m` - Morning
- `p.m` - Evening

This schema supports all documented features and provides a solid foundation for the Edmond Serenity AFH management system with healthcare compliance and scalability built-in.

## Laravel Migration Order

When creating Laravel migrations, follow this order to satisfy foreign key dependencies:

1. `facilities`
2. `branches`
3. `users`
4. `password_reset_tokens`
5. `personal_access_tokens`
6. `residents`
7. `resident_documents`
8. `medications`
9. `resident_medications`
10. `medication_administrations`
11. `vital_signs`
12. `vital_ranges`
13. `healthcare_providers`
14. `appointments`
15. `behavior_categories`
16. `behaviors`
17. `behavior_charts`
18. `sleep_records`
19. `sleep_patterns`
20. `sleep_hourly_data`
21. `assessments`
22. `assessment_sections`
23. `assessment_questions`
24. `incident_reports`
25. `leave_requests`
26. `caregiver_assignments`
27. `communications`
28. `tasks`
29. `charts`
30. `audit_logs`
