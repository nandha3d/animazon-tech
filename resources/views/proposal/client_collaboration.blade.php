<style>
    .collab-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        overflow: hidden;
        margin-top: 2rem;
        background: #ffffff;
    }
    .collab-header {
        background: linear-gradient(135deg, #0f9c86 0%, #0a6f5f 100%);
        color: #ffffff;
        padding: 1.75rem 2rem;
        position: relative;
    }
    .collab-header h4 {
        color: #ffffff;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }
    .collab-header p {
        color: rgba(255,255,255,0.85);
        margin-bottom: 0;
        font-size: 0.95rem;
    }
    .collab-body {
        padding: 2rem;
    }
    .collab-section-title {
        font-weight: 700;
        color: #1e293b;
        font-size: 1.15rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .collab-form-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .collab-form-box label {
        font-weight: 600;
        font-size: 0.85rem;
        color: #475569;
        margin-bottom: 0.35rem;
    }
    .collab-form-box .form-control, .collab-form-box .form-select {
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 0.9rem;
    }
    .collab-form-box .btn-collab {
        background: #0f9c86;
        color: white;
        font-weight: 600;
        border-radius: 8px;
        padding: 0.6rem 1.25rem;
        border: none;
        transition: all 0.2s ease;
    }
    .collab-form-box .btn-collab:hover {
        background: #0a6f5f;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(15, 156, 134, 0.25);
    }
    .comment-list, .attachment-list {
        max-height: 400px;
        overflow-y: auto;
        padding-right: 0.5rem;
    }
    .comment-item {
        padding: 1rem;
        border-radius: 10px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        margin-bottom: 0.85rem;
        transition: all 0.2s;
    }
    .comment-item:hover {
        border-color: #cbd5e1;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .comment-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }
    .comment-author {
        font-weight: 700;
        color: #0f172a;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .comment-author-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(15, 156, 134, 0.15);
        color: #0f9c86;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.85rem;
    }
    .comment-date {
        font-size: 0.75rem;
        color: #94a3b8;
    }
    .comment-text {
        color: #334155;
        font-size: 0.9rem;
        margin-bottom: 0;
        white-space: pre-line;
    }
    .attachment-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.85rem 1rem;
        border-radius: 10px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        margin-bottom: 0.75rem;
    }
    .attachment-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .attachment-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background: #e0f2fe;
        color: #0284c7;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
    .attachment-details h6 {
        margin: 0;
        font-size: 0.9rem;
        font-weight: 600;
        color: #1e293b;
        word-break: break-all;
    }
    .attachment-details span {
        font-size: 0.75rem;
        color: #64748b;
    }
    .badge-collab {
        font-size: 0.7rem;
        padding: 0.25em 0.6em;
        border-radius: 50rem;
        font-weight: 600;
    }
    .badge-feedback { background: #e0e7ff; color: #4338ca; }
    .badge-design { background: #fce7f3; color: #be185d; }
    .badge-req { background: #fef3c7; color: #b45309; }
    .badge-appr { background: #dcfce7; color: #15803d; }
</style>

<div class="card collab-card">
    <div class="collab-header">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h4><i class="ti ti-messages me-2"></i>{{ __('Client Collaboration & Asset Hub') }}</h4>
                <p>{{ __('Have feedback, questions, or need to upload project assets (logos, content, agreements)? Use this secure portal below.') }}</p>
            </div>
            <span class="badge bg-white text-dark px-3 py-2 rounded-pill shadow-sm font-weight-bold">
                <i class="ti ti-lock me-1 text-success"></i> {{ __('Encrypted Portal') }}
            </span>
        </div>
    </div>
    <div class="collab-body">
        <div class="row g-4">
            {{-- Left Column: Discussion & Comments --}}
            <div class="col-lg-6 border-end-lg">
                <div class="collab-section-title">
                    <i class="ti ti-message-dots text-primary fs-4"></i>
                    <span>{{ __('Discussion & Feedback Thread') }}</span>
                    <span class="badge bg-primary rounded-pill ms-auto">{{ isset($proposalComments) ? count($proposalComments) : 0 }}</span>
                </div>

                {{-- Comment Form --}}
                <div class="collab-form-box">
                    <form method="POST" action="{{ route('proposal.public.comment', \Illuminate\Support\Facades\Crypt::encrypt($proposal->id)) }}">
                        @csrf
                        <div class="row g-2 mb-2">
                            <div class="col-sm-6">
                                <label>{{ __('Your Name') }} <span class="text-danger">*</span></label>
                                <input type="text" name="client_name" class="form-control" required placeholder="{{ __('e.g. John Doe') }}" value="{{ (isset($customer->name) && strtolower($customer->name) !== 'random client') ? $customer->name : '' }}">
                            </div>
                            <div class="col-sm-6">
                                <label>{{ __('Topic / Category') }}</label>
                                <select name="category" class="form-select">
                                    <option value="General Feedback">{{ __('General Feedback') }}</option>
                                    <option value="Requirement Clarification">{{ __('Requirement Clarification') }}</option>
                                    <option value="Design Change Request">{{ __('Design Change Request') }}</option>
                                    <option value="Approval & Sign-off">{{ __('Approval & Sign-off') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>{{ __('Comment or Question') }} <span class="text-danger">*</span></label>
                            <textarea name="comment" class="form-control" rows="3" required placeholder="{{ __('Type your message or feedback here...') }}"></textarea>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-collab">
                                <i class="ti ti-send me-1"></i> {{ __('Post Comment') }}
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Comments List --}}
                <div class="comment-list">
                    @if(isset($proposalComments) && count($proposalComments) > 0)
                        @foreach($proposalComments as $comm)
                            @php
                                $badgeClass = 'badge-feedback';
                                if($comm->category == 'Design Change Request') $badgeClass = 'badge-design';
                                elseif($comm->category == 'Requirement Clarification') $badgeClass = 'badge-req';
                                elseif($comm->category == 'Approval & Sign-off') $badgeClass = 'badge-appr';
                            @endphp
                            <div class="comment-item">
                                <div class="comment-meta">
                                    <div class="comment-author">
                                        <div class="comment-author-avatar">
                                            {{ strtoupper(substr($comm->client_name ?? 'C', 0, 1)) }}
                                        </div>
                                        <span>{{ $comm->client_name ?? __('Client') }}</span>
                                        <span class="badge-collab {{ $badgeClass }}">{{ $comm->category }}</span>
                                    </div>
                                    <span class="comment-date">{{ $comm->created_at ? $comm->created_at->diffForHumans() : '' }}</span>
                                </div>
                                <p class="comment-text">{{ $comm->comment }}</p>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="ti ti-message-off fs-2 d-block mb-2 opacity-50"></i>
                            <p class="mb-0">{{ __('No comments yet. Be the first to start the conversation!') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Right Column: File & Asset Uploads --}}
            <div class="col-lg-6">
                <div class="collab-section-title">
                    <i class="ti ti-folder-upload text-success fs-4"></i>
                    <span>{{ __('Project Asset & File Uploads') }}</span>
                    <span class="badge bg-success rounded-pill ms-auto">{{ isset($proposalAttachments) ? count($proposalAttachments) : 0 }}</span>
                </div>

                {{-- Upload Form --}}
                <div class="collab-form-box">
                    <form method="POST" action="{{ route('proposal.public.upload', \Illuminate\Support\Facades\Crypt::encrypt($proposal->id)) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-2 mb-2">
                            <div class="col-sm-6">
                                <label>{{ __('Uploaded By') }} <span class="text-danger">*</span></label>
                                <input type="text" name="client_name" class="form-control" required placeholder="{{ __('Your Name') }}" value="{{ (isset($customer->name) && strtolower($customer->name) !== 'random client') ? $customer->name : '' }}">
                            </div>
                            <div class="col-sm-6">
                                <label>{{ __('Asset Category') }}</label>
                                <select name="category" class="form-select">
                                    <option value="Company Logo & Branding">{{ __('Company Logo & Branding') }}</option>
                                    <option value="Leadership & Team Photos">{{ __('Leadership & Team Photos') }}</option>
                                    <option value="Website Content / Copy">{{ __('Website Content / Copy') }}</option>
                                    <option value="Signed Agreement / PO">{{ __('Signed Agreement / PO') }}</option>
                                    <option value="Other Project Document">{{ __('Other Project Document') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>{{ __('Select File (Max 25MB)') }} <span class="text-danger">*</span></label>
                            <input type="file" name="file" class="form-control" required>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-collab" style="background: #0284c7;">
                                <i class="ti ti-upload me-1"></i> {{ __('Upload Asset') }}
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Attachments List --}}
                <div class="attachment-list">
                    @if(isset($proposalAttachments) && count($proposalAttachments) > 0)
                        @foreach($proposalAttachments as $attach)
                            @php
                                $ext = strtolower(pathinfo($attach->file_name, PATHINFO_EXTENSION));
                                $icon = 'ti-file';
                                if(in_array($ext, ['png','jpg','jpeg','svg','gif','webp'])) $icon = 'ti-photo';
                                elseif(in_array($ext, ['pdf'])) $icon = 'ti-file-text';
                                elseif(in_array($ext, ['zip','rar'])) $icon = 'ti-file-zip';
                            @endphp
                            <div class="attachment-item">
                                <div class="attachment-info">
                                    <div class="attachment-icon">
                                        <i class="ti {{ $icon }}"></i>
                                    </div>
                                    <div class="attachment-details">
                                        <h6>{{ $attach->file_name }}</h6>
                                        <span>
                                            <strong class="text-dark">{{ $attach->client_name }}</strong> &bull; 
                                            <span class="badge bg-light text-secondary border px-2 py-0">{{ $attach->category }}</span> &bull; 
                                            {{ $attach->file_size ?? '' }}
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <a href="{{ asset(\Illuminate\Support\Facades\Storage::url('uploads/proposal_attachments/' . $attach->file_path)) }}" target="_blank" download class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        <i class="ti ti-download me-1"></i> {{ __('Download') }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="ti ti-folder-off fs-2 d-block mb-2 opacity-50"></i>
                            <p class="mb-0">{{ __('No assets or files uploaded yet.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
