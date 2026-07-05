{{-- Bare fragment loaded into the shared #commonModalOver shell (see
     data-ajax-popup-over in public/js/custom.js). Used on pages that are
     THEMSELVES an ajax-loaded modal (revenue/expense/bill/etc create-edit),
     where a second nested Bootstrap modal isn't safe to hand-roll. --}}
<div class="row" id="inlineAddCustomerForm">
    <div class="alert alert-danger d-none" id="inlineAddCustomerError"></div>
    <div class="col-md-6 form-group">
        <label class="form-label">{{ __('Name') }}<x-required></x-required></label>
        <input type="text" class="form-control" name="name" required>
    </div>
    <div class="col-md-6 form-group">
        <label class="form-label">{{ __('Email') }}<x-required></x-required></label>
        <input type="email" class="form-control" name="email" required>
    </div>
    <div class="col-md-6 form-group">
        <label class="form-label">{{ __('Contact') }}<x-required></x-required></label>
        <input type="text" class="form-control" name="contact" required>
    </div>
    <div class="col-md-6 form-group">
        <label class="form-label">{{ __('Billing Name') }}</label>
        <input type="text" class="form-control" name="billing_name">
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
    <button type="button" class="btn btn-primary" id="inlineSaveNewCustomer">{{ __('Save Customer') }}</button>
</div>

<script>
    (function () {
        var url = '{{ route('customer.store.ajax') }}';

        $(document).off('click', '#inlineSaveNewCustomer').on('click', '#inlineSaveNewCustomer', function () {
            var $btn = $(this);
            var $err = $('#inlineAddCustomerError').addClass('d-none').text('');
            var data = { _token: '{{ csrf_token() }}' };
            $('#inlineAddCustomerForm').find('input').each(function () {
                data[$(this).attr('name')] = $(this).val();
            });

            $btn.prop('disabled', true);
            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function (res) {
                    var $sel = $('select[name="customer_id"]');
                    if ($sel.find('option[value="' + res.id + '"]').length === 0) {
                        $sel.append(new Option(res.text, res.id, true, true));
                    }
                    $sel.val(res.id).trigger('change');

                    $('#commonModalOver').modal('hide');
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
