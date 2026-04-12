@extends('layouts.landing')

@section('page_content')
<section class="py-16 bg-animazon-black text-animazon-white min-h-screen">
    <div class="container mx-auto px-4 lg:px-8 max-w-4xl">

        <!-- Header -->
        <div class="text-center mb-12">
            <span class="inline-block px-4 py-1 rounded-full bg-primary/20 text-primary text-sm font-bold mb-4">LEGAL</span>
            <h1 class="text-3xl md:text-5xl font-bold text-animazon-white mb-4">
                Terms & <span class="text-gradient">Conditions</span>
            </h1>
            <p class="text-animazon-muted">Last updated: {{ date('F j, Y') }}</p>
        </div>

        <div class="bg-animazon-dark border border-animazon-border/30 rounded-2xl p-6 md:p-10 space-y-8 leading-relaxed text-animazon-muted">

            <!-- 1. Scope of Work -->
            <div>
                <h2 class="text-xl font-bold text-animazon-white mb-3 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary text-sm font-bold">1</span>
                    Scope of Work & Estimates
                </h2>
                <ul class="space-y-2 pl-6 list-disc">
                    <li>All pricing shown through our online calculator is an <strong class="text-animazon-white">estimated range</strong> and is not a binding quote. Final pricing is confirmed only after a detailed scope discussion with our project team.</li>
                    <li>The estimate covers <strong class="text-animazon-white">development costs only</strong>. Third-party service fees (hosting, domain names, SSL certificates, API subscriptions, payment gateway transaction fees, app store developer accounts, etc.) are <strong class="text-animazon-white">not included</strong> and are the client's responsibility.</li>
                    <li>Any work outside the agreed scope will be treated as a change request and may incur additional charges, which will be communicated before implementation.</li>
                    <li>We reserve the right to decline projects that do not align with our capabilities or ethical standards.</li>
                </ul>
            </div>

            <!-- 2. Payment Terms -->
            <div>
                <h2 class="text-xl font-bold text-animazon-white mb-3 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary text-sm font-bold">2</span>
                    Payment Terms
                </h2>
                <ul class="space-y-2 pl-6 list-disc">
                    <li><strong class="text-animazon-white">Milestone-based payments</strong>: Projects are invoiced in stages — typically 40% upfront, 30% at mid-milestone, and 30% upon delivery and testing.</li>
                    <li>For projects under <strong class="text-animazon-white">$500 USD</strong> (or equivalent), full payment may be required upfront before work begins.</li>
                    <li>We accept payments via bank transfer, PayPal, Stripe, Razorpay (UPI), and other methods as communicated in the proposal.</li>
                    <li>Invoices are due within <strong class="text-animazon-white">7 business days</strong> of issuance. Late payments may result in project delays. Outstanding balances beyond 30 days may incur a 1.5% monthly late fee.</li>
                    <li>All prices are quoted in the currency shown on the estimate. Exchange rate fluctuations after proposal acceptance are the client's responsibility.</li>
                </ul>
            </div>

            <!-- 3. Intellectual Property -->
            <div>
                <h2 class="text-xl font-bold text-animazon-white mb-3 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary text-sm font-bold">3</span>
                    Intellectual Property Rights
                </h2>
                <ul class="space-y-2 pl-6 list-disc">
                    <li>Upon full and final payment, all custom-developed code, designs, and assets created specifically for the client's project are transferred to the client as <strong class="text-animazon-white">full intellectual property</strong>.</li>
                    <li>Pre-existing frameworks, libraries, templates, and tools used during development remain the property of their respective licensors. The client receives a perpetual, non-exclusive license to use them within the delivered project.</li>
                    <li>Source files (Figma, PSD, project files, etc.) are delivered only when explicitly included in the project scope or purchased as an add-on.</li>
                    <li>We reserve the right to use anonymized screenshots or descriptions of the delivered work in our portfolio, unless a confidentiality agreement is in place.</li>
                </ul>
            </div>

            <!-- 4. Revisions -->
            <div>
                <h2 class="text-xl font-bold text-animazon-white mb-3 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary text-sm font-bold">4</span>
                    Revision Policy
                </h2>
                <ul class="space-y-2 pl-6 list-disc">
                    <li>Each project includes <strong class="text-animazon-white">1 round of revisions</strong> per milestone at no additional cost. Revisions must be submitted within 7 days of milestone delivery.</li>
                    <li>Additional revision rounds can be purchased as specified in the project proposal or calculator add-ons.</li>
                    <li>"Revisions" refer to changes within the original scope — not new features or redesigns. Changes that alter the project scope will be quoted separately as change requests.</li>
                </ul>
            </div>

            <!-- 5. Confidentiality -->
            <div>
                <h2 class="text-xl font-bold text-animazon-white mb-3 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary text-sm font-bold">5</span>
                    Confidentiality & Data Protection
                </h2>
                <ul class="space-y-2 pl-6 list-disc">
                    <li>We treat all client-provided materials, business information, and project details as <strong class="text-animazon-white">strictly confidential</strong>.</li>
                    <li>Personal information collected via our estimate form (name, email, phone) is used solely for project communication and is not sold or shared with third parties.</li>
                    <li>For projects requiring formal non-disclosure, we offer a mutual NDA upon request, at no additional charge.</li>
                    <li>We comply with applicable data protection regulations. Client data is stored securely and can be deleted upon written request after project completion.</li>
                </ul>
            </div>

            <!-- 6. Delivery & Timelines -->
            <div>
                <h2 class="text-xl font-bold text-animazon-white mb-3 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary text-sm font-bold">6</span>
                    Delivery & Timelines
                </h2>
                <ul class="space-y-2 pl-6 list-disc">
                    <li>Timeline estimates provided by the calculator are approximate and depend on client responsiveness with feedback, content, and approvals.</li>
                    <li>Delays caused by late client feedback, missing assets, or scope changes will extend the delivery timeline accordingly.</li>
                    <li>We provide weekly progress updates and milestone demos. Communication is via email, WhatsApp, or a dedicated project channel.</li>
                    <li>Force majeure events (natural disasters, pandemics, infrastructure failures) may affect timelines. We will communicate any such delays promptly.</li>
                </ul>
            </div>

            <!-- 7. Cancellation & Refunds -->
            <div>
                <h2 class="text-xl font-bold text-animazon-white mb-3 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary text-sm font-bold">7</span>
                    Cancellation & Refund Policy
                </h2>
                <ul class="space-y-2 pl-6 list-disc">
                    <li><strong class="text-animazon-white">Before work begins:</strong> Full refund of any advance payment, minus a 5% processing fee.</li>
                    <li><strong class="text-animazon-white">During development:</strong> Refund is prorated based on work completed to date. All completed deliverables up to the point of cancellation are provided to the client.</li>
                    <li><strong class="text-animazon-white">After delivery:</strong> No refunds are issued after final delivery and client sign-off.</li>
                    <li>Cancellation requests must be submitted in writing (email) to our project manager.</li>
                </ul>
            </div>

            <!-- 8. Warranties & Support -->
            <div>
                <h2 class="text-xl font-bold text-animazon-white mb-3 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary text-sm font-bold">8</span>
                    Warranties & Post-Launch Support
                </h2>
                <ul class="space-y-2 pl-6 list-disc">
                    <li>All projects come with a <strong class="text-animazon-white">30-day bug-fix warranty</strong> after final delivery, covering defects in the delivered scope.</li>
                    <li>This warranty does not cover issues caused by client modifications, third-party plugin updates, hosting changes, or browser/OS updates.</li>
                    <li>Extended maintenance plans (3, 6, or 12 months) can be purchased as add-ons during the estimate process.</li>
                </ul>
            </div>

            <!-- 9. Limitation of Liability -->
            <div>
                <h2 class="text-xl font-bold text-animazon-white mb-3 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary text-sm font-bold">9</span>
                    Limitation of Liability
                </h2>
                <ul class="space-y-2 pl-6 list-disc">
                    <li>Our total liability shall not exceed the total amount paid by the client for the specific project in question.</li>
                    <li>We are not liable for lost revenue, data loss, business interruption, or any indirect, incidental, or consequential damages arising from the use of our deliverables.</li>
                    <li>The client is responsible for maintaining backups, security patches, and updates after project handover (unless a support plan is active).</li>
                </ul>
            </div>

            <!-- 10. Governing Law -->
            <div>
                <h2 class="text-xl font-bold text-animazon-white mb-3 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary text-sm font-bold">10</span>
                    Governing Law
                </h2>
                <ul class="space-y-2 pl-6 list-disc">
                    <li>These terms are governed by and construed in accordance with the laws of India. Any disputes shall be subject to the exclusive jurisdiction of the courts in Chennai, Tamil Nadu, India.</li>
                    <li>For international clients, we encourage amicable resolution through discussion before formal proceedings.</li>
                </ul>
            </div>

            <!-- Contact -->
            <div class="border-t border-animazon-border/30 pt-6 text-center">
                <p class="text-animazon-white font-semibold mb-2">Questions about these terms?</p>
                <p>Contact us at <a href="mailto:legal@animazon.in" class="text-primary hover:underline">legal@animazon.in</a> or reach out through our <a href="{{ url('/') }}#contact" class="text-primary hover:underline">contact form</a>.</p>
            </div>
        </div>

        <!-- Back to pricing -->
        <div class="text-center mt-8">
            <a href="{{ route('cost-calculator.public') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-primary/10 text-primary rounded-xl hover:bg-primary/20 transition-all font-semibold">
                <i class="ti ti-arrow-left"></i> Back to Pricing
            </a>
        </div>
    </div>
</section>
@endsection
