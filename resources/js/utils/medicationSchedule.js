import { toPacificDateFromTime, getPacificNow } from './pacificTime';

const PACIFIC_TZ = 'America/Los_Angeles';

const adminTimeFmt = new Intl.DateTimeFormat('en-US', {
    timeZone: PACIFIC_TZ,
    year: 'numeric',
    month: '2-digit',
    day: '2-digit',
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit',
    hour12: false,
});

/** Same Pacific parsing as medication list badges (UTC components = Pacific clock). */
export function parseAdminTimeToPacific(administeredAt) {
    const raw = new Date(administeredAt);
    if (Number.isNaN(raw.getTime())) return null;
    const p = {};
    adminTimeFmt.formatToParts(raw).forEach(({ type, value }) => {
        if (type !== 'literal') p[type] = parseInt(value, 10);
    });
    return new Date(Date.UTC(p.year, p.month - 1, p.day, p.hour, p.minute, p.second || 0));
}

/** Aligns with App\Services\MedicationService::getMedicationsWithStatus */
export const MEDICATION_SLOT_COVER_STATUSES = [
    'completed',
    'refused',
    'hospital_admission',
    'pharmacy_administration_confirm',
];

export function getMedicationAdministrations(medication) {
    const admins = medication?.administrations;
    return Array.isArray(admins) ? admins : [];
}

/**
 * True when today's loaded administrations include a dose within ±60 min of this slot
 * (same rule as backend "slot satisfied" for hiding fully-administered meds).
 */
export function isMedicationSlotCoveredToday(medication, slotTime) {
    if (!slotTime) return false;
    const scheduledTime = toPacificDateFromTime(slotTime, { referenceDate: getPacificNow() });
    if (!scheduledTime) return false;
    return getMedicationAdministrations(medication).some((admin) => {
        if (!MEDICATION_SLOT_COVER_STATUSES.includes(admin.status)) return false;
        const adminTime = parseAdminTimeToPacific(admin.administered_at);
        if (!adminTime) return false;
        const diffMs = Math.abs(adminTime.getTime() - scheduledTime.getTime());
        return diffMs <= 60 * 60 * 1000;
    });
}

/** Medications with no time_1–time_4: treat row as done if any covering administration exists today. */
export function isNoScheduledTimeRowCoveredToday(medication) {
    return getMedicationAdministrations(medication).some((admin) =>
        MEDICATION_SLOT_COVER_STATUSES.includes(admin.status),
    );
}
