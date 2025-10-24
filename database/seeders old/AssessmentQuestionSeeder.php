<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Assessment;
use App\Models\AssessmentSection;
use App\Models\AssessmentQuestion;

class AssessmentQuestionSeeder extends Seeder
{
    public function run(): void
    {
        // Get all assessments and create questions for each section
        $assessments = Assessment::with('sections')->get();
        
        foreach ($assessments as $assessment) {
            $this->createQuestionsForAssessment($assessment);
        }
    }

    public static function createQuestionsForNewAssessment(Assessment $assessment): void
    {
        $seeder = new self();
        $seeder->createQuestionsForAssessment($assessment);
    }

    protected function createQuestionsForAssessment(Assessment $assessment): void
    {
        foreach ($assessment->sections as $section) {
            $this->createQuestionsForSection($section);
        }
    }

    protected function createQuestionsForSection(AssessmentSection $section): void
    {
        $questions = $this->getQuestionsForSectionType($section->section_type);
        
        foreach ($questions as $questionData) {
            AssessmentQuestion::create([
                'assessment_section_id' => $section->id,
                'question_text' => $questionData['text'],
                'response_type' => $questionData['type'],
                'response_options' => $questionData['options'] ?? null,
                'weight' => $questionData['order'] ?? 1,
            ]);
        }
    }

    protected function getQuestionsForSectionType(string $sectionType): array
    {
        return match ($sectionType) {
            'demographic' => [
                [
                    'text' => 'What is the resident\'s full name?',
                    'type' => 'text',
                    'required' => true,
                    'order' => 1,
                ],
                [
                    'text' => 'Date of birth?',
                    'type' => 'date',
                    'required' => true,
                    'order' => 2,
                ],
                [
                    'text' => 'Gender',
                    'type' => 'select',
                    'options' => ['Male' => 'Male', 'Female' => 'Female', 'Other' => 'Other'],
                    'required' => true,
                    'order' => 3,
                ],
                [
                    'text' => 'Emergency contact name',
                    'type' => 'text',
                    'required' => true,
                    'order' => 4,
                ],
                [
                    'text' => 'Emergency contact phone',
                    'type' => 'text',
                    'required' => true,
                    'order' => 5,
                ],
            ],
            'medical_history' => [
                [
                    'text' => 'Primary diagnosis',
                    'type' => 'text',
                    'required' => true,
                    'order' => 1,
                ],
                [
                    'text' => 'Known allergies',
                    'type' => 'text',
                    'required' => false,
                    'order' => 2,
                ],
                [
                    'text' => 'Current medications',
                    'type' => 'text',
                    'required' => false,
                    'order' => 3,
                ],
                [
                    'text' => 'Physician name',
                    'type' => 'text',
                    'required' => true,
                    'order' => 4,
                ],
                [
                    'text' => 'Physician phone',
                    'type' => 'text',
                    'required' => true,
                    'order' => 5,
                ],
            ],
            'functional' => [
                [
                    'text' => 'Can the resident walk independently?',
                    'type' => 'radio',
                    'options' => ['Yes' => 'Yes', 'No' => 'No', 'With assistance' => 'With assistance'],
                    'required' => true,
                    'order' => 1,
                ],
                [
                    'text' => 'Can the resident dress independently?',
                    'type' => 'radio',
                    'options' => ['Yes' => 'Yes', 'No' => 'No', 'With assistance' => 'With assistance'],
                    'required' => true,
                    'order' => 2,
                ],
                [
                    'text' => 'Can the resident feed themselves?',
                    'type' => 'radio',
                    'options' => ['Yes' => 'Yes', 'No' => 'No', 'With assistance' => 'With assistance'],
                    'required' => true,
                    'order' => 3,
                ],
                [
                    'text' => 'Can the resident use the bathroom independently?',
                    'type' => 'radio',
                    'options' => ['Yes' => 'Yes', 'No' => 'No', 'With assistance' => 'With assistance'],
                    'required' => true,
                    'order' => 4,
                ],
            ],
            'cognitive' => [
                [
                    'text' => 'Is the resident oriented to person, place, and time?',
                    'type' => 'radio',
                    'options' => ['Fully oriented' => 'Fully oriented', 'Partially oriented' => 'Partially oriented', 'Not oriented' => 'Not oriented'],
                    'required' => true,
                    'order' => 1,
                ],
                [
                    'text' => 'Can the resident follow simple instructions?',
                    'type' => 'radio',
                    'options' => ['Yes' => 'Yes', 'No' => 'No', 'Sometimes' => 'Sometimes'],
                    'required' => true,
                    'order' => 2,
                ],
                [
                    'text' => 'Does the resident have memory issues?',
                    'type' => 'radio',
                    'options' => ['No' => 'No', 'Mild' => 'Mild', 'Moderate' => 'Moderate', 'Severe' => 'Severe'],
                    'required' => true,
                    'order' => 3,
                ],
            ],
            'behavioral' => [
                [
                    'text' => 'Does the resident exhibit any challenging behaviors?',
                    'type' => 'radio',
                    'options' => ['No' => 'No', 'Occasionally' => 'Occasionally', 'Frequently' => 'Frequently'],
                    'required' => true,
                    'order' => 1,
                ],
                [
                    'text' => 'If yes, please describe the behaviors',
                    'type' => 'text',
                    'required' => false,
                    'order' => 2,
                ],
                [
                    'text' => 'Does the resident have any sleep disturbances?',
                    'type' => 'radio',
                    'options' => ['No' => 'No', 'Occasionally' => 'Occasionally', 'Frequently' => 'Frequently'],
                    'required' => true,
                    'order' => 3,
                ],
            ],
            'nutritional' => [
                [
                    'text' => 'Does the resident have any dietary restrictions?',
                    'type' => 'radio',
                    'options' => ['No' => 'No', 'Yes' => 'Yes'],
                    'required' => true,
                    'order' => 1,
                ],
                [
                    'text' => 'If yes, please describe the restrictions',
                    'type' => 'text',
                    'required' => false,
                    'order' => 2,
                ],
                [
                    'text' => 'Can the resident eat independently?',
                    'type' => 'radio',
                    'options' => ['Yes' => 'Yes', 'No' => 'No', 'With assistance' => 'With assistance'],
                    'required' => true,
                    'order' => 3,
                ],
            ],
            'environmental' => [
                [
                    'text' => 'Is the resident\'s living environment safe?',
                    'type' => 'radio',
                    'options' => ['Yes' => 'Yes', 'No' => 'No', 'Needs improvement' => 'Needs improvement'],
                    'required' => true,
                    'order' => 1,
                ],
                [
                    'text' => 'Are there any safety concerns in the environment?',
                    'type' => 'text',
                    'required' => false,
                    'order' => 2,
                ],
            ],
            'risk' => [
                [
                    'text' => 'Is the resident at risk for falls?',
                    'type' => 'radio',
                    'options' => ['Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High'],
                    'required' => true,
                    'order' => 1,
                ],
                [
                    'text' => 'Is the resident at risk for wandering?',
                    'type' => 'radio',
                    'options' => ['Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High'],
                    'required' => true,
                    'order' => 2,
                ],
                [
                    'text' => 'Are there any other safety concerns?',
                    'type' => 'text',
                    'required' => false,
                    'order' => 3,
                ],
            ],
            default => [],
        };
    }
}
