<?php

namespace App\Http\Controllers;

use App\Models\ProjectType;
use App\Models\CostCalculatorQuestion;
use App\Models\CostCalculatorAnswer;
use App\Models\CostEstimate;
use App\Models\CostEstimateAnswer;
use App\Models\User;
use App\Models\Lead;
use App\Models\Project;
use App\Notifications\EstimateSubmittedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class CostCalculatorController extends Controller
{
    /**
     * Currency rates relative to USD (base = 1 USD)
     */
    public const CURRENCY_MAP = [
        'US' => ['code' => 'USD', 'symbol' => '$', 'rate' => 1.00, 'name' => 'US Dollar'],
        'GB' => ['code' => 'GBP', 'symbol' => '£', 'rate' => 0.79, 'name' => 'British Pound'],
        'EU' => ['code' => 'EUR', 'symbol' => '€', 'rate' => 0.92, 'name' => 'Euro'],
        'IN' => ['code' => 'INR', 'symbol' => '₹', 'rate' => 83.50, 'name' => 'Indian Rupee'],
        'AE' => ['code' => 'AED', 'symbol' => 'د.إ', 'rate' => 3.67, 'name' => 'UAE Dirham'],
        'SA' => ['code' => 'SAR', 'symbol' => '﷼', 'rate' => 3.75, 'name' => 'Saudi Riyal'],
        'AU' => ['code' => 'AUD', 'symbol' => 'A$', 'rate' => 1.53, 'name' => 'Australian Dollar'],
        'CA' => ['code' => 'CAD', 'symbol' => 'C$', 'rate' => 1.36, 'name' => 'Canadian Dollar'],
        'JP' => ['code' => 'JPY', 'symbol' => '¥', 'rate' => 151.00, 'name' => 'Japanese Yen'],
        'SG' => ['code' => 'SGD', 'symbol' => 'S$', 'rate' => 1.34, 'name' => 'Singapore Dollar'],
        'MY' => ['code' => 'MYR', 'symbol' => 'RM', 'rate' => 4.72, 'name' => 'Malaysian Ringgit'],
        'DE' => ['code' => 'EUR', 'symbol' => '€', 'rate' => 0.92, 'name' => 'Euro'],
        'FR' => ['code' => 'EUR', 'symbol' => '€', 'rate' => 0.92, 'name' => 'Euro'],
        'IT' => ['code' => 'EUR', 'symbol' => '€', 'rate' => 0.92, 'name' => 'Euro'],
        'ES' => ['code' => 'EUR', 'symbol' => '€', 'rate' => 0.92, 'name' => 'Euro'],
        'NL' => ['code' => 'EUR', 'symbol' => '€', 'rate' => 0.92, 'name' => 'Euro'],
        'CH' => ['code' => 'CHF', 'symbol' => 'Fr', 'rate' => 0.88, 'name' => 'Swiss Franc'],
        'SE' => ['code' => 'SEK', 'symbol' => 'kr', 'rate' => 10.50, 'name' => 'Swedish Krona'],
        'NO' => ['code' => 'NOK', 'symbol' => 'kr', 'rate' => 10.80, 'name' => 'Norwegian Krone'],
        'NZ' => ['code' => 'NZD', 'symbol' => 'NZ$', 'rate' => 1.67, 'name' => 'New Zealand Dollar'],
        'ZA' => ['code' => 'ZAR', 'symbol' => 'R', 'rate' => 18.50, 'name' => 'South African Rand'],
        'BR' => ['code' => 'BRL', 'symbol' => 'R$', 'rate' => 5.05, 'name' => 'Brazilian Real'],
        'MX' => ['code' => 'MXN', 'symbol' => 'MX$', 'rate' => 17.20, 'name' => 'Mexican Peso'],
        'KR' => ['code' => 'KRW', 'symbol' => '₩', 'rate' => 1320.00, 'name' => 'South Korean Won'],
        'CN' => ['code' => 'CNY', 'symbol' => '¥', 'rate' => 7.24, 'name' => 'Chinese Yuan'],
        'HK' => ['code' => 'HKD', 'symbol' => 'HK$', 'rate' => 7.83, 'name' => 'Hong Kong Dollar'],
        'TH' => ['code' => 'THB', 'symbol' => '฿', 'rate' => 35.50, 'name' => 'Thai Baht'],
        'PH' => ['code' => 'PHP', 'symbol' => '₱', 'rate' => 56.20, 'name' => 'Philippine Peso'],
        'EG' => ['code' => 'EGP', 'symbol' => 'E£', 'rate' => 30.90, 'name' => 'Egyptian Pound'],
        'NG' => ['code' => 'NGN', 'symbol' => '₦', 'rate' => 1550.00, 'name' => 'Nigerian Naira'],
        'KE' => ['code' => 'KES', 'symbol' => 'KSh', 'rate' => 153.00, 'name' => 'Kenyan Shilling'],
        'PK' => ['code' => 'PKR', 'symbol' => '₨', 'rate' => 278.00, 'name' => 'Pakistani Rupee'],
        'BD' => ['code' => 'BDT', 'symbol' => '৳', 'rate' => 110.00, 'name' => 'Bangladeshi Taka'],
        'LK' => ['code' => 'LKR', 'symbol' => 'Rs', 'rate' => 310.00, 'name' => 'Sri Lankan Rupee'],
        'QA' => ['code' => 'QAR', 'symbol' => 'QR', 'rate' => 3.64, 'name' => 'Qatari Riyal'],
        'KW' => ['code' => 'KWD', 'symbol' => 'KD', 'rate' => 0.31, 'name' => 'Kuwaiti Dinar'],
        'BH' => ['code' => 'BHD', 'symbol' => 'BD', 'rate' => 0.38, 'name' => 'Bahraini Dinar'],
        'OM' => ['code' => 'OMR', 'symbol' => 'OMR', 'rate' => 0.39, 'name' => 'Omani Rial'],
    ];

    /**
     * Country names for the dropdown
     */
    private const COUNTRIES = [
        'US' => 'United States', 'GB' => 'United Kingdom', 'IN' => 'India',
        'AE' => 'United Arab Emirates', 'SA' => 'Saudi Arabia', 'QA' => 'Qatar',
        'KW' => 'Kuwait', 'BH' => 'Bahrain', 'OM' => 'Oman',
        'AU' => 'Australia', 'CA' => 'Canada', 'NZ' => 'New Zealand',
        'DE' => 'Germany', 'FR' => 'France', 'IT' => 'Italy',
        'ES' => 'Spain', 'NL' => 'Netherlands', 'CH' => 'Switzerland',
        'SE' => 'Sweden', 'NO' => 'Norway',
        'JP' => 'Japan', 'SG' => 'Singapore', 'MY' => 'Malaysia',
        'KR' => 'South Korea', 'CN' => 'China', 'HK' => 'Hong Kong',
        'TH' => 'Thailand', 'PH' => 'Philippines',
        'BR' => 'Brazil', 'MX' => 'Mexico',
        'ZA' => 'South Africa', 'NG' => 'Nigeria', 'KE' => 'Kenya', 'EG' => 'Egypt',
        'PK' => 'Pakistan', 'BD' => 'Bangladesh', 'LK' => 'Sri Lanka',
    ];

    /**
     * Public: Show the project type selection page (categories + sub-services)
     */
    public function publicIndex()
    {
        $categories = ProjectType::whereNull('parent_id')
            ->where('active', true)
            ->with(['children' => function ($q) {
                $q->where('active', true)->orderBy('name');
            }])
            ->orderBy('name')
            ->get();

        $countries = self::COUNTRIES;
        
        // Fetch live currency rates using Frankfurter, cached for 12 hours
        $currencies = \Illuminate\Support\Facades\Cache::remember('live_cost_calculator_currencies', 43200, function () {
            $currencyMap = self::CURRENCY_MAP;
            $symbols = collect($currencyMap)->pluck('code')->unique()->toArray();
            
            // Cost calculator base prices are always stored in USD,
            // so always convert relative to USD regardless of admin site_currency
            $baseCurrency = 'USD';

            try {
                // Fetch rates from Frankfurter API with EUR as base (most compatible)
                $response = \Illuminate\Support\Facades\Http::timeout(5)->get('https://api.frankfurter.app/latest', [
                    'symbols' => implode(',', array_unique(array_merge($symbols, [$baseCurrency])))
                ]);
                
                if ($response->successful()) {
                    $rates = $response->json()['rates'] ?? [];
                    $rates['EUR'] = 1.0; // Implicit base
                    
                    // The rate of the base currency compared to EUR
                    $baseRate = $rates[$baseCurrency] ?? 1.0;
                    
                    // Convert all currency map rates relative to the new base currency
                    foreach ($currencyMap as $country => $details) {
                        $targetRate = $rates[$details['code']] ?? null;
                        if ($targetRate !== null) {
                            $currencyMap[$country]['rate'] = $targetRate / $baseRate;
                        }
                    }
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Cost Calculator Frankfurter API failed: ' . $e->getMessage());
                // Silently fallback to hardcoded self::CURRENCY_MAP
            }
            
            return $currencyMap;
        });

        return view('cost-calculator.public-index', compact('categories', 'countries', 'currencies'));
    }

    /**
     * Public: Show the calculator wizard for a specific sub-service
     */
    public function publicCalculator($projectType)
    {
        // Try finding by slug first, then ID
        $projectType = ProjectType::where('slug', $projectType)
            ->orWhere('id', $projectType)
            ->firstOrFail();

        $projectType->load(['parent', 'children' => function($q) {
            $q->where('active', true)->orderBy('name');
        }]);

        $projectTypeId = $projectType->id;

        // If it's a category, show the drill-down view of its sub-services
        if ($projectType->isCategory()) {
            $countries = self::COUNTRIES;
            $currencies = self::CURRENCY_MAP;
            return view('cost-calculator.public-category', compact('projectType', 'countries', 'currencies'));
        }

        // Allow custom projects to proceed to the wizard so they see the custom estimation UI
        // Removal of redirect!
        $questions = CostCalculatorQuestion::where('project_type_id', $projectTypeId)
            ->where('active', true)
            ->with(['answers' => function ($q) {
                $q->where('active', true)->orderBy('order');
            }])
            ->orderBy('order')
            ->get();

        // Get sibling services for the nav
        $siblings = ProjectType::where('parent_id', $projectType->parent_id)
            ->where('active', true)
            ->where('base_cost', '>', 0)
            ->orderBy('name')
            ->get();

        $countries = self::COUNTRIES;
        $currencies = self::CURRENCY_MAP;

        return view('cost-calculator.public-calculator', compact(
            'projectType', 'questions', 'siblings', 'countries', 'currencies'
        ));
    }

    /**
     * Public: Calculate cost via AJAX (no auth required)
     */
    public function publicCalculate(Request $request)
    {
        $request->validate([
            'project_type_id' => 'required|exists:project_types,id',
            'answers' => 'required|array',
            'country_code' => 'nullable|string|max:5',
        ]);

        $projectTypeId = $request->input('project_type_id');
        $answers = $request->input('answers', []);
        $countryCode = $request->input('country_code', 'US');

        $projectType = ProjectType::findOrFail($projectTypeId);
        $baseCost = (float)$projectType->base_cost;

        // India gets base pricing; all other countries get 2x
        $internationalMultiplier = ($countryCode !== 'IN') ? 2.0 : 1.0;

        $totalMultiplier = 1.0;
        $additionalCosts = 0;
        $costBreakdown = [];

        foreach ($answers as $questionId => $answer) {
            $question = CostCalculatorQuestion::with(['answers' => function ($q) {
                $q->where('active', true);
            }])->find($questionId);

            if (!$question) continue;

            if ($question->type === 'single_select' || $question->type === 'multi_select') {
                $answerIds = is_array($answer) ? $answer : [$answer];

                foreach ($answerIds as $answerId) {
                    $answerObj = CostCalculatorAnswer::find($answerId);
                    if (!$answerObj) continue;

                    $costBreakdown[] = [
                        'question' => $question->question,
                        'answer' => $answerObj->answer_text,
                        'multiplier' => $answerObj->cost_multiplier,
                        'additional_cost' => $answerObj->additional_cost * $internationalMultiplier,
                    ];

                    $totalMultiplier *= (float)$answerObj->cost_multiplier;
                    $additionalCosts += (float)$answerObj->additional_cost;
                }
            } elseif ($question->type === 'input') {
                $val = 0;
                if (is_array($answer)) {
                    $val = floatval($answer['value'] ?? ($answer[0] ?? 0));
                } else {
                    $val = floatval($answer);
                }
                
                if ($val > 0) {
                    $answerObj = $question->answers->first();
                    if ($answerObj) {
                        $costBreakdown[] = [
                            'question' => $question->question,
                            'answer' => $val . ' × ' . $answerObj->answer_text,
                            'multiplier' => $answerObj->cost_multiplier > 0 ? ($answerObj->cost_multiplier * $val) : 1,
                            'additional_cost' => $answerObj->additional_cost * $val * $internationalMultiplier,
                        ];

                        if ((float)$answerObj->cost_multiplier > 0) {
                            $totalMultiplier *= ((float)$answerObj->cost_multiplier * $val);
                        }
                        $additionalCosts += ((float)$answerObj->additional_cost * $val);
                    }
                }
            }
        }

        $totalCostUsd = ($baseCost * $totalMultiplier) + $additionalCosts;

        // Apply 2x international margin on USD total BEFORE currency conversion
        $totalCostUsd *= $internationalMultiplier;
        $baseCostEffective = $baseCost * $internationalMultiplier;

        // Convert to local currency
        $currency = self::CURRENCY_MAP[$countryCode] ?? self::CURRENCY_MAP['US'];
        $totalCostLocal = $totalCostUsd * $currency['rate'];
        $baseCostLocal = $baseCostEffective * $currency['rate'];
        $additionalCostsLocal = ($additionalCosts * $internationalMultiplier) * $currency['rate'];

        // Timeline and team estimation based on original USD scope (not inflated)
        $scopeCost = ($baseCost * $totalMultiplier) + $additionalCosts;
        $timeline = $this->estimateTimeline($scopeCost);
        $teamSize = $this->estimateTeamSize($scopeCost);

        return response()->json([
            'success' => true,
            'project_type' => $projectType->name,
            'base_cost_usd' => round($baseCostEffective, 2),
            'base_cost_local' => round($baseCostLocal, 2),
            'total_multiplier' => round($totalMultiplier, 2),
            'additional_costs_usd' => round($additionalCosts * $internationalMultiplier, 2),
            'additional_costs_local' => round($additionalCostsLocal, 2),
            'total_cost_usd' => round($totalCostUsd, 2),
            'total_cost_local' => round($totalCostLocal, 2),
            'currency' => $currency,
            'timeline_weeks' => $timeline,
            'team_size' => $teamSize,
            'cost_breakdown' => $costBreakdown,
            'international_margin' => $internationalMultiplier,
        ]);
    }

    /**
     * Public: Submit estimate with visitor info (lead capture)
     */
    public function publicSubmit(Request $request)
    {
        // Simple honeypot check
        if (!empty($request->website_url)) {
            // Bot detected, pretend it succeeded
            return response()->json(['success' => true, 'message' => 'Estimate submitted successfully.']);
        }

        // Clean up empty string values for integer fields
        if ($request->timeline_weeks === '') $request->merge(['timeline_weeks' => null]);
        if ($request->team_size === '') $request->merge(['team_size' => null]);

        $request->validate([
            'project_type_id' => 'required|exists:project_types,id',
            'visitor_name' => 'required|string|max:255',
            'visitor_email' => 'required|email|max:255',
            'visitor_phone' => 'nullable|string|max:50',
            'total_cost' => 'required|numeric',
            'grand_total' => 'required|numeric',
            'currency_code' => 'nullable|string|max:5',
            'country_code' => 'nullable|string|max:5',
            'timeline_weeks' => 'nullable|integer',
            'team_size' => 'nullable|integer',
            'notes' => 'nullable|string|max:2000',
            'answers' => 'nullable|array',
            'document' => 'nullable|file|mimes:pdf,doc,docx,zip,jpeg,png,jpg|max:10240',
            'agree_terms' => 'accepted',
        ]);

        $projectType = ProjectType::findOrFail($request->project_type_id);
        $countryCode = $request->country_code ?? 'US';
        $currency = self::CURRENCY_MAP[$countryCode] ?? self::CURRENCY_MAP['US'];

        $documentPath = null;
        if ($request->hasFile('document')) {
            $documentPath = $request->file('document')->store('estimates/documents', 'public');
        }

        $estimate = CostEstimate::create([
            'project_type_id' => $request->project_type_id,
            'project_name' => $projectType->name . ' Project - ' . $request->visitor_name,
            'visitor_name' => $request->visitor_name,
            'visitor_email' => $request->visitor_email,
            'visitor_phone' => $request->visitor_phone,
            'base_cost' => $projectType->base_cost,
            'total_cost' => $request->total_cost,
            'tax_percentage' => 0,
            'tax_amount' => 0,
            'grand_total' => $request->grand_total,
            'currency_code' => $currency['code'],
            'timeline_weeks' => $request->timeline_weeks,
            'team_size' => $request->team_size,
            'notes' => $request->notes,
            'document_path' => $documentPath,
            'status' => 'draft',
        ]);

        // Store answers
        if (!empty($request->answers) && is_array($request->answers)) {
            foreach ($request->answers as $questionId => $answer) {
                $question = CostCalculatorQuestion::find($questionId);
                if (!$question) continue;

                if ($question->type === 'single_select' || $question->type === 'multi_select') {
                    $answerIds = is_array($answer) ? $answer : [$answer];
                    foreach ($answerIds as $answerId) {
                        $answerObj = CostCalculatorAnswer::find($answerId);
                        if (!$answerObj) continue;

                        CostEstimateAnswer::create([
                            'cost_estimate_id' => $estimate->id,
                            'question_id' => $questionId,
                            'answer_id' => $answerId,
                            'cost_contribution' => ($estimate->base_cost * ($answerObj->cost_multiplier - 1)) + $answerObj->additional_cost,
                        ]);
                    }
                } else {
                    CostEstimateAnswer::create([
                        'cost_estimate_id' => $estimate->id,
                        'question_id' => $questionId,
                        'answer_value' => $answer,
                    ]);
                }
            }
        }

        // Identify the company admin for assigning CRM Leads and Projects
        $adminUser = User::where('type', 'company')->first() ?? User::where('type', 'super admin')->first();
        $adminId = $adminUser ? $adminUser->id : 1;

        // Create CRM Lead
        try {
            $pipelineId = \DB::table('pipelines')->where('created_by', $adminId)->value('id');
            if (!$pipelineId) {
                $pipelineId = \DB::table('pipelines')->value('id') ?? 1;
            }
            
            $stageId = \DB::table('lead_stages')->where('pipeline_id', $pipelineId)->value('id') ?? 1;
            
            $lead = Lead::create([
                'name' => $request->visitor_name,
                'email' => $request->visitor_email,
                'phone' => $request->visitor_phone,
                'subject' => 'Project Enquiry: ' . $projectType->name,
                'pipeline_id' => $pipelineId,
                'stage_id' => $stageId,
                'sources' => 'Website Cost Calculator',
                'products' => $projectType->name,
                'notes' => "Estimated Timeline: " . ((int)$request->timeline_weeks ?? 'N/A') . " weeks\n" .
                           "Estimated Price: " . $currency['symbol'] . $request->total_cost . "\n" .
                           "Estimate Link: " . url('/cost-estimate/' . $estimate->id) . "\n" .
                           "Additional Notes: " . $request->notes,
                'order' => 0,
                'created_by' => $adminId,
                'is_active' => 1,
                'is_converted' => 0,
                'date' => now()->format('Y-m-d'),
            ]);
        } catch (\Exception $e) {
            Log::warning('CRM Lead generation failed: ' . $e->getMessage());
        }

        // Create Project in Projects section
        try {
            Project::create([
                'project_name' => $projectType->name . ' - ' . $request->visitor_name,
                'start_date' => now()->format('Y-m-d'),
                'end_date' => $request->timeline_weeks ? now()->addWeeks((int)$request->timeline_weeks)->format('Y-m-d') : null,
                'budget' => (int)$request->total_cost,
                'client_id' => 0,
                'description' => "Source: Cost Calculator Estimate\n" .
                                 "Client Email: " . $request->visitor_email . "\n" .
                                 "Client Notes: " . $request->notes,
                'status' => 'estimated',
                'estimated_hrs' => ((int)$request->timeline_weeks * 40 * ((int)$request->team_size ?: 1)),
                'created_by' => $adminId,
            ]);
        } catch (\Exception $e) {
            Log::warning('Project generation failed: ' . $e->getMessage());
        }

        // Send notifications
        try {
            // Configure SMTP mailer from database settings (same pattern as Utility::sendEmailTemplate)
            // This is required because public routes don't trigger the DB mail config automatically
            $mailSettings = \App\Models\Utility::settingsById($adminId);
            
            // Use DB settings if available, otherwise fall back to .env values
            $mailDriver = !empty($mailSettings['mail_driver']) ? $mailSettings['mail_driver'] : env('MAIL_DRIVER', 'smtp');
            $mailHost = !empty($mailSettings['mail_host']) ? $mailSettings['mail_host'] : env('MAIL_HOST', 'smtp.hostinger.com');
            $mailPort = !empty($mailSettings['mail_port']) ? $mailSettings['mail_port'] : env('MAIL_PORT', 465);
            $mailEncryption = !empty($mailSettings['mail_encryption']) ? $mailSettings['mail_encryption'] : env('MAIL_ENCRYPTION', 'ssl');
            $mailUsername = !empty($mailSettings['mail_username']) ? $mailSettings['mail_username'] : env('MAIL_USERNAME');
            $mailPassword = !empty($mailSettings['mail_password']) ? $mailSettings['mail_password'] : env('MAIL_PASSWORD');
            $mailFromAddress = !empty($mailSettings['mail_from_address']) ? $mailSettings['mail_from_address'] : env('MAIL_FROM_ADDRESS', 'info@animazon.in');
            $mailFromName = !empty($mailSettings['mail_from_name']) ? $mailSettings['mail_from_name'] : env('MAIL_FROM_NAME', 'ANIMAZON');

            config([
                'mail.default' => $mailDriver,
                'mail.mailers.smtp.transport' => $mailDriver,
                'mail.mailers.smtp.host' => $mailHost,
                'mail.mailers.smtp.port' => $mailPort,
                'mail.mailers.smtp.encryption' => $mailEncryption,
                'mail.mailers.smtp.username' => $mailUsername,
                'mail.mailers.smtp.password' => $mailPassword,
                'mail.from.address' => $mailFromAddress,
                'mail.from.name' => $mailFromName,
                'mail.mailers.smtp.verify_peer' => false,
                'mail.mailers.smtp.stream' => [
                    'ssl' => [
                        'allow_self_signed' => true,
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                    ],
                ],
            ]);

            // Force Laravel to create a fresh mailer instance with the new config
            app()->forgetInstance('mail.manager');

            // 1. Notify the Company/Admin
            $notifyEmail = env('ESTIMATE_NOTIFY_EMAIL', 'info@animazon.in');
            Notification::route('mail', $notifyEmail)->notify(new EstimateSubmittedNotification($estimate));

            if ($adminUser) {
                $adminUser->notify(new EstimateSubmittedNotification($estimate));
            }

            // 2. Notify the Client with the estimation summary document
            if (!empty($request->visitor_email)) {
                Notification::route('mail', $request->visitor_email)
                    ->notify(new \App\Notifications\ClientEstimateSummaryNotification($estimate));
            }
        } catch (\Exception $e) {
            Log::warning('Estimate notification failed: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Thank you! Your estimate has been submitted. We\'ll contact you shortly.',
            'estimate_id' => $estimate->id,
        ]);
    }

    /**
     * API: Get currency info for a country code
     */
    public function getCurrency(Request $request)
    {
        $countryCode = $request->input('country_code', 'US');
        $currency = self::CURRENCY_MAP[$countryCode] ?? self::CURRENCY_MAP['US'];

        return response()->json([
            'success' => true,
            'currency' => $currency,
            'country_code' => $countryCode,
        ]);
    }

    /**
     * Detect visitor country by IP using ip-api.com
     */
    public function detectCountry(Request $request)
    {
        try {
            $ip = $request->ip();

            // Skip for localhost / private IPs
            if (in_array($ip, ['127.0.0.1', '::1']) || str_starts_with($ip, '192.168.') || str_starts_with($ip, '10.')) {
                return response()->json(['country_code' => 'IN', 'source' => 'localhost_default']);
            }

            $response = Http::timeout(3)->get("http://ip-api.com/json/{$ip}", [
                'fields' => 'countryCode,status',
            ]);

            if ($response->ok() && $response->json('status') === 'success') {
                $code = $response->json('countryCode');
                // Map EU codes that use EUR
                $eurCodes = ['DE', 'FR', 'IT', 'ES', 'NL', 'AT', 'BE', 'FI', 'IE', 'PT', 'GR'];
                if (in_array($code, $eurCodes) && !isset(self::COUNTRIES[$code])) {
                    $code = 'DE'; // default EU representative
                }
                // If the country isn't in our list, pick a safe default
                if (!isset(self::COUNTRIES[$code])) {
                    $code = 'US';
                }
                return response()->json(['country_code' => $code, 'source' => 'ip_api']);
            }
        } catch (\Exception $e) {
            Log::debug('IP detection failed: ' . $e->getMessage());
        }

        return response()->json(['country_code' => 'US', 'source' => 'fallback']);
    }

    // ─── Private Helpers ────────────────────────────────────────

    private function estimateTimeline($costUsd)
    {
        if ($costUsd <= 500) return 1;
        if ($costUsd <= 1500) return 2;
        if ($costUsd <= 3000) return 4;
        if ($costUsd <= 6000) return 6;
        if ($costUsd <= 12000) return 8;
        if ($costUsd <= 25000) return 12;
        if ($costUsd <= 50000) return 16;
        return max(4, ceil($costUsd / 3000));
    }

    private function estimateTeamSize($costUsd)
    {
        if ($costUsd <= 500) return 1;
        if ($costUsd <= 2000) return 2;
        if ($costUsd <= 5000) return 3;
        if ($costUsd <= 12000) return 4;
        if ($costUsd <= 25000) return 5;
        if ($costUsd <= 50000) return 6;
        return max(2, min(12, ceil($costUsd / 8000)));
    }

    /**
     * View the estimation document
     */
    public function viewEstimate($id)
    {
        $estimate = CostEstimate::with(['answers.question', 'answers.answer', 'projectType'])->findOrFail($id);

        // If admin is logged in, mark any related notifications as read
        if (\Auth::check()) {
            $user = \Auth::user();
            foreach ($user->unreadNotifications as $notification) {
                if (isset($notification->data['estimate_id']) && $notification->data['estimate_id'] == $id) {
                    $notification->markAsRead();
                }
            }
        }

        // Fetch settings explicitly by admin user (works for public/unauthenticated visitors)
        $adminUser = User::where('type', 'owner')->first() ?? User::where('type', 'company')->first() ?? User::where('type', 'super admin')->first();
        $adminId = $adminUser ? $adminUser->id : 1;

        // Get company settings - use settingsById to avoid Auth dependency
        $settingsData = \App\Models\Utility::getSettingById($adminId);
        $settings = [];
        foreach ($settingsData as $row) {
            $settings[$row->name] = $row->value;
        }

        // Get Razorpay details using the Utility class which handles company/admin logic
        $paymentSettings = \App\Models\Utility::getCompanyPaymentSetting($adminId);
        
        // If company settings are empty, fallback to admin settings
        if (empty($paymentSettings) || !isset($paymentSettings['is_razorpay_enabled'])) {
            $paymentSettings = \App\Models\Utility::getAdminPaymentSetting();
        }
        
        $razorpayKey = null;
        if (isset($paymentSettings['is_razorpay_enabled']) && $paymentSettings['is_razorpay_enabled'] === 'on') {
            $razorpayKey = $paymentSettings['razorpay_public_key'] ?? null;
        }
        
        // Fallback to env if DB is empty
        if (!$razorpayKey) {
            $razorpayKey = env('RAZORPAY_KEY');
        }

        // Calculate conversion factors for itemized pricing display
        $currencyCode = $estimate->currency_code ?? 'USD';
        $clientRate = 1;
        $isInternational = true;
        foreach (self::CURRENCY_MAP as $key => $val) {
            if ($val['code'] === $currencyCode) { 
                $clientRate = $val['rate']; 
                if ($key === 'IN') $isInternational = false;
                break; 
            }
        }
        $internationalMultiplier = $isInternational ? 2.0 : 1.0;

        return view('cost-calculator.estimate-document', compact(
            'estimate', 
            'settings', 
            'razorpayKey', 
            'clientRate', 
            'internationalMultiplier'
        ));
    }

    /**
     * Accept estimate and process Razorpay advance payment
     */
    public function acceptAndPay(Request $request, $id)
    {
        $estimate = CostEstimate::findOrFail($id);

        // Prevent double-acceptance
        if ($estimate->status === 'Accepted') {
            return redirect()->back()->with('error', 'This estimate has already been accepted.');
        }

        // Validate Razorpay payment
        $request->validate([
            'razorpay_payment_id' => 'required|string',
            'amount' => 'required|numeric|min:1',
        ]);

        $adminUser = User::where('type', 'owner')->first() ?? User::where('type', 'company')->first() ?? User::where('type', 'super admin')->first();
        $adminId = $adminUser ? $adminUser->id : 1;

        $paymentSettings = \App\Models\Utility::getCompanyPaymentSetting($adminId);
        if (empty($paymentSettings) || !isset($paymentSettings['is_razorpay_enabled'])) {
            $paymentSettings = \App\Models\Utility::getAdminPaymentSetting();
        }

        $secretKey = $paymentSettings['razorpay_secret_key'] ?? '';
        $publicKey = $paymentSettings['razorpay_public_key'] ?? '';

        // Verify payment with Razorpay API
        try {
            $ch = curl_init('https://api.razorpay.com/v1/payments/' . $request->razorpay_payment_id);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_USERPWD, $publicKey . ':' . $secretKey);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = json_decode(curl_exec($ch));
            curl_close($ch);

            if (!$response || !isset($response->status) || !in_array($response->status, ['authorized', 'captured'])) {
                Log::warning('Razorpay payment verification failed for estimate #' . $id, [
                    'payment_id' => $request->razorpay_payment_id,
                    'response' => $response,
                ]);
                return redirect()->back()->with('error', 'Payment verification failed. Please contact support.');
            }
        } catch (\Exception $e) {
            Log::error('Razorpay verification error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Payment verification error. Please contact support.');
        }

        // Update estimate status
        $estimate->update([
            'status' => 'Accepted',
            'accepted_at' => now(),
            'notes' => ($estimate->notes ? $estimate->notes . "\n\n" : '') .
                       "--- Payment Record ---\n" .
                       "Razorpay Payment ID: " . $request->razorpay_payment_id . "\n" .
                       "Amount Paid: ₹" . number_format($request->amount, 2) . "\n" .
                       "Paid At: " . now()->format('M d, Y h:i A'),
        ]);

        // Notify admin about acceptance
        try {
            $adminUser = User::where('type', 'owner')->first();
            $adminId = $adminUser ? $adminUser->id : 1;
            $mailSettings = \App\Models\Utility::settingsById($adminId);

            $mailDriver = !empty($mailSettings['mail_driver']) ? $mailSettings['mail_driver'] : env('MAIL_DRIVER', 'smtp');
            $mailHost = !empty($mailSettings['mail_host']) ? $mailSettings['mail_host'] : env('MAIL_HOST');
            $mailPort = !empty($mailSettings['mail_port']) ? $mailSettings['mail_port'] : env('MAIL_PORT');
            $mailEncryption = !empty($mailSettings['mail_encryption']) ? $mailSettings['mail_encryption'] : env('MAIL_ENCRYPTION');
            $mailUsername = !empty($mailSettings['mail_username']) ? $mailSettings['mail_username'] : env('MAIL_USERNAME');
            $mailPassword = !empty($mailSettings['mail_password']) ? $mailSettings['mail_password'] : env('MAIL_PASSWORD');
            $mailFromAddress = !empty($mailSettings['mail_from_address']) ? $mailSettings['mail_from_address'] : env('MAIL_FROM_ADDRESS');
            $mailFromName = !empty($mailSettings['mail_from_name']) ? $mailSettings['mail_from_name'] : env('MAIL_FROM_NAME');

            config([
                'mail.default' => $mailDriver,
                'mail.mailers.smtp.transport' => $mailDriver,
                'mail.mailers.smtp.host' => $mailHost,
                'mail.mailers.smtp.port' => $mailPort,
                'mail.mailers.smtp.encryption' => $mailEncryption,
                'mail.mailers.smtp.username' => $mailUsername,
                'mail.mailers.smtp.password' => $mailPassword,
                'mail.from.address' => $mailFromAddress,
                'mail.from.name' => $mailFromName,
            ]);
            app()->forgetInstance('mail.manager');

            $notifyEmail = env('ESTIMATE_NOTIFY_EMAIL', $mailFromAddress);
            \Illuminate\Support\Facades\Notification::route('mail', $notifyEmail)
                ->notify(new \App\Notifications\EstimateAcceptedNotification($estimate, $request->razorpay_payment_id, $request->amount));
        } catch (\Exception $e) {
            Log::warning('Estimate acceptance notification failed: ' . $e->getMessage());
        }

        return redirect()->route('cost-estimate.view', $id)
            ->with('success', 'Payment successful! Agreement accepted. Our team will begin work shortly.');
    }
}
