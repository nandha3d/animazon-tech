# Project Cost Calculator - Complete Setup Guide

## Overview
A comprehensive project cost estimation tool for your Laravel application that dynamically calculates costs based on:
- Project type (Website, Mobile App, 3D Design, etc.)
- Industry-standard questions for each type
- Multiple answer options with cost multipliers
- Automatic timeline and team size estimation

## 📋 Features

### Core Functionality
- ✅ Dynamic project type selection
- ✅ Customizable questions and answers per project type
- ✅ Real-time cost calculation with multipliers
- ✅ Tax calculation and estimation breakdown
- ✅ Timeline and team size estimation
- ✅ Save estimates for client review
- ✅ Email estimates to clients
- ✅ Estimate status tracking (draft, sent, accepted, rejected)

### Industry-Standard Questions Included
**Website Development:**
- Website complexity level (Basic, Standard, Advanced, Enterprise)
- Required features (Auth, Payments, APIs, Search, Admin Dashboard)
- Timeline requirements (Flexible, Standard, Urgent, Rush)
- Design needs (No design, Unique design, Premium branding)

**Mobile App Development:**
- Platform selection (iOS, Android, Native, Cross-platform)
- App complexity (Simple, Medium, Complex, Enterprise)
- Backend requirements
- API integration needs

**3D Design & Rendering:**
- Project type (Product, Architecture, Animation, Environment)
- Quality levels
- Revision rounds
- Delivery format

## 🚀 Installation Steps

### Step 1: Run Migrations
```bash
php artisan migrate
```

This creates the following tables:
- `project_types` - Project type configurations
- `cost_calculator_questions` - Survey questions
- `cost_calculator_answers` - Answer options with costs
- `cost_estimates` - Stored client estimates
- `cost_estimate_answers` - User responses to questions

### Step 2: Seed Sample Data
```bash
php artisan db:seed --class=CostCalculatorSeeder
```

This populates:
- 3 pre-configured project types with full question sets
- Industry-standard questions and answers
- Realistic cost multipliers and pricing

### Step 3: Configure in Admin Menu (Optional)
Add to your navigation menu:
```blade
<li>
    <a href="{{ route('cost-calculator.index') }}" class="nav-link">
        <i class="ti ti-calculator"></i> Cost Calculator
    </a>
</li>
```

## 📊 Cost Calculation Formula

```
Total Cost = (Base Cost × Total Multiplier) + Additional Costs
Tax Amount = Total Cost × Tax Percentage
Grand Total = Total Cost + Tax Amount
```

### Example Calculation
**Website Project:**
- Base Cost: $5,000
- Website Type: Advanced (×1.8, +$2,000)
- Features Selected: Auth (×1.2, +$500), Payments (×1.3, +$1,000)
- Timeline: Standard (×1.1, +$500)
- Design: Unique (×1.4, +$1,000)

```
Base × Multipliers: $5,000 × 1.8 × 1.2 × 1.3 × 1.1 × 1.4 = $20,196
Plus Additional: $20,196 + $5,000 = $25,196
Tax (15%): $3,779.40
Grand Total: $28,975.40
Timeline: 8 weeks
Team: 6 members
```

## 🎯 Usage Guide

### For Clients/Users
1. Navigate to `Cost Calculator` → Select a project type
2. Answer the survey questions about their project
3. Click "Calculate Cost" to see the estimate
4. Review the breakdown (Base Cost, Features, Timeline, Tax)
5. Enter project name and optionally select client
6. Click "Save Estimate" to create an estimate

### For Admins
1. **View Estimates:** `Cost Estimates` menu shows all created estimates
2. **Send Estimates:** Click the send button to send estimates to clients
3. **Manage Questions:** Add/edit questions via database or admin panel
4. **Track Status:** Monitor estimate status (Draft, Sent, Accepted, Rejected)

### For Developers

#### Customizing Project Types
Edit `CostCalculatorSeeder.php` and run:
```bash
php artisan db:seed --class=CostCalculatorSeeder
```

#### Adding New Questions
```php
$question = CostCalculatorQuestion::create([
    'project_type_id' => $projectType->id,
    'question' => 'Your question here?',
    'description' => 'Optional helper text',
    'type' => 'single_select', // or 'multi_select', 'input'
    'order' => 5,
    'required' => true,
    'category' => 'scope', // or 'timeline', 'features', 'design'
    'active' => true,
]);
```

#### Adding Answer Options
```php
CostCalculatorAnswer::create([
    'question_id' => $question->id,
    'answer_text' => 'Premium Package',
    'cost_multiplier' => 1.5, // Multiplies base cost
    'additional_cost' => 1000, // Fixed amount to add
    'explanation' => 'Optional tip shown to user',
    'order' => 1,
    'active' => true,
]);
```

## 🔧 Configuration

### Default Tax Percentage
In `CostCalculatorController.php`, line 99:
```php
$taxPercentage = setting('default_tax_percentage', 15); // 15% default
```

To change, update the setting or modify the value directly.

### Timeline Estimation
Line 197:
```php
private function estimateTimeline($cost)
{
    return max(1, ceil($cost / 2000)); // ~$2,000 per week
}
```

### Team Size Estimation
Line 204:
```php
private function estimateTeamSize($cost)
{
    return max(1, ceil($cost / 5000)); // 1 person per $5,000
}
```

## 📁 File Structure

```
app/
├── Http/Controllers/
│   └── CostCalculatorController.php
├── Models/
│   ├── ProjectType.php
│   ├── CostCalculatorQuestion.php
│   ├── CostCalculatorAnswer.php
│   ├── CostEstimate.php
│   └── CostEstimateAnswer.php
database/
├── migrations/
│   ├── 2024_03_31_100001_create_project_types_table.php
│   ├── 2024_03_31_100002_create_cost_calculator_questions_table.php
│   ├── 2024_03_31_100003_create_cost_calculator_answers_table.php
│   ├── 2024_03_31_100004_create_cost_estimates_table.php
│   └── 2024_03_31_100005_create_cost_estimate_answers_table.php
├── seeders/
│   └── CostCalculatorSeeder.php
resources/views/cost-calculator/
├── index.blade.php           # Project type selection
├── calculator.blade.php       # Survey & calculation form
├── estimate-show.blade.php   # Individual estimate details
└── estimates-list.blade.php  # All estimates listing
```

## 🔗 Routes

| Route | Method | Purpose |
|-------|--------|---------|
| `/cost-calculator` | GET | View all project types |
| `/cost-calculator/{id}` | GET | View calculator for project type |
| `/cost-calculator/calculate` | POST | Calculate cost estimate |
| `/cost-estimates` | GET | List all estimates |
| `/cost-estimates/{id}` | GET | View specific estimate |
| `/cost-estimates/{id}/send` | POST | Send estimate to client |

## 💡 Best Practices

1. **Cost Multipliers:** Keep between 0.5 and 3.0 for reasonable pricing
2. **Categories:** Organize questions by: scope, timeline, features, design
3. **Required Fields:** Mark critical questions as required
4. **Order:** Number questions logically for better UX
5. **Testing:** Test cost calculations with various combinations

## 🐛 Troubleshooting

### Questions Not Showing
- Verify `active` field is `true` in database
- Check `project_type_id` is correct
- Ensure questions have answers

### Incorrect Calculations
- Verify `cost_multiplier` values are correct
- Check `additional_cost` amounts
- Ensure formula in controller matches your requirements

### Estimates Not Saving
- Verify all required fields are filled
- Check database permissions
- Review error logs in `storage/logs`

## 📧 Email Configuration

To enable email functionality, update the `send()` method in controller:

```php
Mail::to($estimate->client->email)->send(
    new EstimateMail($estimate)
);
```

Create the Mailable:
```bash
php artisan make:mail EstimateMail
```

## 📈 Future Enhancements

- PDF export with branding
- Estimate comparison tool
- Invoice generation from accepted estimates
- Recurring project templates
- Team member assignment with capacity planning
- Budget tracking vs. actual costs
- Integration with project management tools

## 🤝 Support

For issues or feature requests, refer to the database tables and controller logic for customization points.

## 📝 License

Built for the Animazon application. Modify as needed for your business requirements.

---

**Created:** March 31, 2024  
**Last Updated:** March 31, 2024  
**Version:** 1.0
