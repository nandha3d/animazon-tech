{{-- Inline "Add Customer" modal. Creates a customer via AJAX and injects it
     into the #customer dropdown without leaving the current page. --}}
<div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCustomerModalLabel">{{ __('Add New Customer') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="addCustomerError"></div>
                <div class="row" id="addCustomerForm">
                    <div class="col-md-4 form-group">
                        <label class="form-label">{{ __('Name') }}<x-required></x-required></label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="form-label">{{ __('Email') }}<x-required></x-required></label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="form-label">{{ __('Contact') }}<x-required></x-required></label>
                        <input type="text" class="form-control" name="contact" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="form-label">{{ __('Tax Number') }}</label>
                        <input type="text" class="form-control" name="tax_number">
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="form-label">{{ __('Billing Name') }}</label>
                        <input type="text" class="form-control" name="billing_name">
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="form-label">{{ __('Billing Phone') }}</label>
                        <input type="text" class="form-control" name="billing_phone">
                    </div>
                    <div class="col-md-12 form-group">
                        <label class="form-label">{{ __('Billing Address') }}</label>
                        <textarea class="form-control" name="billing_address" rows="2"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="button" class="btn btn-primary" id="saveNewCustomer">
                    <span class="btn-label">{{ __('Save Customer') }}</span>
                </button>
            </div>
        </div>
    </div>
</div>

@push('script-page')
    <script>
        (function () {
            var url = '{{ route('customer.store.ajax') }}';

            function tokenVal() {
                return document.getElementById('token') ? document.getElementById('token').value : '{{ csrf_token() }}';
            }

            $(document).on('click', '#saveNewCustomer', function () {
                var $btn = $(this);
                var $err = $('#addCustomerError').addClass('d-none').text('');
                var data = { _token: tokenVal() };
                $('#addCustomerForm').find('input, textarea').each(function () {
                    data[$(this).attr('name')] = $(this).val();
                });

                $btn.prop('disabled', true);
                $.ajax({
                    url: url,
                    type: 'POST',
                    headers: { 'X-CSRF-TOKEN': tokenVal() },
                    data: data,
                    success: function (res) {
                        // add to dropdown, select it, trigger any page-specific detail loader
                        var $sel = $('select[name="customer_id"]');
                        if ($sel.find('option[value="' + res.id + '"]').length === 0) {
                            $sel.append(new Option(res.text, res.id, true, true));
                        }
                        $sel.val(res.id).trigger('change');

                        $('#addCustomerForm').find('input, textarea').val('');
                        var m = bootstrap.Modal.getInstance(document.getElementById('addCustomerModal'));
                        if (m) m.hide();
                        if (typeof show_toastr === 'function') {
                            show_toastr('{{ __('Success') }}', res.message || '{{ __('Customer created') }}', 'success');
                        }
                    },
                    error: function (xhr) {
                        var msg = (xhr.responseJSON && xhr.responseJSON.error) ? xhr.responseJSON.error : '{{ __('Something went wrong.') }}';
                        $err.removeClass('d-none').text(msg);
                    },
                    complete: function () {
                        $btn.prop('disabled', false);
                    }
                });
            });
        })();
    </script>
@endpush
