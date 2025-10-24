<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmployeeDocument;
use App\Models\User;
use Carbon\Carbon;

class EmployeeDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['administrator', 'super_admin', 'caregiver']);
        })->get();

        if ($users->isEmpty()) {
            $this->command->warn('No users found. Please run UserSeeder first.');
            return;
        }

        $documentTypes = [
            'Employment Contract',
            'Background Check',
            'Criminal Record Check',
            'Reference Letters',
            'Education Certificates',
            'Professional Licenses',
            'CPR Certification',
            'First Aid Training',
            'Health Screening',
            'TB Test Results',
            'Immunization Records',
            'Drug Test Results',
            'Performance Reviews',
            'Training Certificates',
            'Insurance Documents',
            'Emergency Contact Form',
            'Photo ID',
            'Social Security Card',
            'Driver\'s License',
            'Work Authorization'
        ];

        $statuses = ['active', 'expired', 'pending_renewal', 'under_review'];
        $priorities = ['low', 'medium', 'high', 'urgent'];

        foreach ($users as $user) {
            // Create 3-8 documents per user
            $documentCount = rand(3, 8);
            
            for ($i = 0; $i < $documentCount; $i++) {
                $documentType = $documentTypes[array_rand($documentTypes)];
                $createdAt = Carbon::now()->subDays(rand(1, 365));
                $expirationDate = $createdAt->copy()->addDays(rand(30, 1095)); // 1 month to 3 years
                
                EmployeeDocument::create([
                    'user_id' => $user->id,
                    'document_name' => $this->generateDocumentTitle($documentType),
                    'document_type' => $documentType,
                    'file_path' => $this->generateFilePath($documentType),
                    'file_name' => $this->generateFileName($documentType),
                    'file_size' => (string) rand(1024, 10485760), // 1KB to 10MB
                    'mime_type' => $this->getMimeType($documentType),
                    'expiration_date' => $expirationDate->format('Y-m-d'),
                    'is_expired' => $expirationDate->isPast(),
                    'notes' => $this->generateDocumentNotes(),
                    'is_active' => rand(0, 1) == 1,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
            }
        }

        $this->command->info('EmployeeDocumentSeeder completed successfully!');
    }

    private function generateDocumentTitle(string $documentType): string
    {
        $titles = [
            'Employment Contract' => 'Employment Agreement - ' . date('Y'),
            'Background Check' => 'Criminal Background Check Report',
            'Criminal Record Check' => 'Criminal Record Verification',
            'Reference Letters' => 'Professional Reference Letter',
            'Education Certificates' => 'Educational Qualification Certificate',
            'Professional Licenses' => 'Professional License - ' . date('Y'),
            'CPR Certification' => 'CPR/AED Certification Card',
            'First Aid Training' => 'First Aid Training Certificate',
            'Health Screening' => 'Pre-Employment Health Screening',
            'TB Test Results' => 'Tuberculosis Test Results',
            'Immunization Records' => 'Immunization Record',
            'Drug Test Results' => 'Pre-Employment Drug Screening',
            'Performance Reviews' => 'Annual Performance Review',
            'Training Certificates' => 'Professional Development Certificate',
            'Insurance Documents' => 'Health Insurance Card',
            'Emergency Contact Form' => 'Emergency Contact Information',
            'Photo ID' => 'Employee Photo Identification',
            'Social Security Card' => 'Social Security Card Copy',
            'Driver\'s License' => 'Driver\'s License Copy',
            'Work Authorization' => 'Work Authorization Document'
        ];

        return $titles[$documentType] ?? $documentType;
    }

    private function generateDocumentDescription(string $documentType): string
    {
        $descriptions = [
            'Employment Contract' => 'Official employment agreement outlining terms and conditions of employment.',
            'Background Check' => 'Comprehensive background verification report from authorized agency.',
            'Criminal Record Check' => 'Official criminal record verification from law enforcement agency.',
            'Reference Letters' => 'Professional reference letters from previous employers or colleagues.',
            'Education Certificates' => 'Official educational qualification certificates and transcripts.',
            'Professional Licenses' => 'Current professional license documentation and renewals.',
            'CPR Certification' => 'Current CPR and AED certification from recognized training provider.',
            'First Aid Training' => 'First aid and emergency response training certification.',
            'Health Screening' => 'Pre-employment health assessment and medical clearance.',
            'TB Test Results' => 'Tuberculosis screening test results and medical clearance.',
            'Immunization Records' => 'Complete immunization record including required vaccinations.',
            'Drug Test Results' => 'Pre-employment drug screening results from certified laboratory.',
            'Performance Reviews' => 'Annual performance evaluation and assessment documentation.',
            'Training Certificates' => 'Professional development and continuing education certificates.',
            'Insurance Documents' => 'Health insurance coverage documentation and cards.',
            'Emergency Contact Form' => 'Emergency contact information and next of kin details.',
            'Photo ID' => 'Official employee photo identification card.',
            'Social Security Card' => 'Social Security card copy for employment verification.',
            'Driver\'s License' => 'Valid driver\'s license for transportation and field work.',
            'Work Authorization' => 'Legal work authorization and employment eligibility documentation.'
        ];

        return $descriptions[$documentType] ?? 'Document description not available.';
    }

    private function generateFilePath(string $documentType): string
    {
        $fileExtensions = [
            'Employment Contract' => 'pdf',
            'Background Check' => 'pdf',
            'Criminal Record Check' => 'pdf',
            'Reference Letters' => 'pdf',
            'Education Certificates' => 'pdf',
            'Professional Licenses' => 'pdf',
            'CPR Certification' => 'jpg',
            'First Aid Training' => 'pdf',
            'Health Screening' => 'pdf',
            'TB Test Results' => 'pdf',
            'Immunization Records' => 'pdf',
            'Drug Test Results' => 'pdf',
            'Performance Reviews' => 'pdf',
            'Training Certificates' => 'pdf',
            'Insurance Documents' => 'jpg',
            'Emergency Contact Form' => 'pdf',
            'Photo ID' => 'jpg',
            'Social Security Card' => 'jpg',
            'Driver\'s License' => 'jpg',
            'Work Authorization' => 'pdf'
        ];

        $extension = $fileExtensions[$documentType] ?? 'pdf';
        return 'employee_documents/' . strtolower(str_replace(' ', '_', $documentType)) . '_' . uniqid() . '.' . $extension;
    }

    private function generateFileName(string $documentType): string
    {
        $extension = $this->getFileExtension($documentType);
        return strtolower(str_replace(' ', '_', $documentType)) . '_' . date('Y_m_d') . '.' . $extension;
    }

    private function getFileExtension(string $documentType): string
    {
        $extensions = [
            'Employment Contract' => 'pdf',
            'Background Check' => 'pdf',
            'Criminal Record Check' => 'pdf',
            'Reference Letters' => 'pdf',
            'Education Certificates' => 'pdf',
            'Professional Licenses' => 'pdf',
            'CPR Certification' => 'jpg',
            'First Aid Training' => 'pdf',
            'Health Screening' => 'pdf',
            'TB Test Results' => 'pdf',
            'Immunization Records' => 'pdf',
            'Drug Test Results' => 'pdf',
            'Performance Reviews' => 'pdf',
            'Training Certificates' => 'pdf',
            'Insurance Documents' => 'jpg',
            'Emergency Contact Form' => 'pdf',
            'Photo ID' => 'jpg',
            'Social Security Card' => 'jpg',
            'Driver\'s License' => 'jpg',
            'Work Authorization' => 'pdf'
        ];

        return $extensions[$documentType] ?? 'pdf';
    }

    private function getMimeType(string $documentType): string
    {
        $mimeTypes = [
            'Employment Contract' => 'application/pdf',
            'Background Check' => 'application/pdf',
            'Criminal Record Check' => 'application/pdf',
            'Reference Letters' => 'application/pdf',
            'Education Certificates' => 'application/pdf',
            'Professional Licenses' => 'application/pdf',
            'CPR Certification' => 'image/jpeg',
            'First Aid Training' => 'application/pdf',
            'Health Screening' => 'application/pdf',
            'TB Test Results' => 'application/pdf',
            'Immunization Records' => 'application/pdf',
            'Drug Test Results' => 'application/pdf',
            'Performance Reviews' => 'application/pdf',
            'Training Certificates' => 'application/pdf',
            'Insurance Documents' => 'image/jpeg',
            'Emergency Contact Form' => 'application/pdf',
            'Photo ID' => 'image/jpeg',
            'Social Security Card' => 'image/jpeg',
            'Driver\'s License' => 'image/jpeg',
            'Work Authorization' => 'application/pdf'
        ];

        return $mimeTypes[$documentType] ?? 'application/pdf';
    }

    private function generateDocumentNotes(): string
    {
        $notes = [
            'Document uploaded successfully and verified.',
            'All information is current and up-to-date.',
            'Document meets all regulatory requirements.',
            'Verification completed by HR department.',
            'Document is valid and authentic.',
            'All signatures and dates are verified.',
            'Document complies with company policies.',
            'Background verification completed successfully.',
            'Document is ready for review and approval.',
            'All required information is present and accurate.',
        ];

        return $notes[array_rand($notes)];
    }
}
