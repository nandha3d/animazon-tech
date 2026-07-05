{{-- Bare fragment loaded into the shared #commonModalOver shell (see
     data-ajax-popup-over in public/js/custom.js). $type comes from the
     'id' query param, which the caller sets via data-validate pointing at
     a hidden input holding 'income' or 'expense' (see custom.js: it reads
     that field's value and appends it as ?id=...). --}}
@php $type = request('id') === 'expense' ? 'expense' : 'income'; @endphp
<div class="row" id="inlineAddCategoryForm">
    <div class="alert alert-danger d-none" id="inlineAddCategoryError"></div>
    <input type="hidden" name="type" value="{{ $type }}">
    <div class="col-md-8 form-group">
        <label class="form-label">{{ __('Name') }}<x-required></x-required></label>
        <input type="text" class="form-control" name="name" required>
    </div>
    <div class="col-md-4 form-group">
        <label class="form-label">{{ __('Color') }}<x-required></x-required></label>
        <input type="color" class="form-control form-control-color" name="color" value="#6777ef">
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
    <button type="button" class="btn btn-primary" id="inlineSaveNewCategory">{{ __('Save Category') }}</button>
</div>

<script>
    (function () {
        var url = '{{ route('product-category.store.ajax') }}';

        $(document).off('click', '#inlineSaveNewCategory').on('click', '#inlineSaveNewCategory', function () {
            var $btn = $(this);
            var $err = $('#inlineAddCategoryError').addClass('d-none').text('');
            var data = { _token: '{{ csrf_token() }}' };
            $('#inlineAddCategoryForm').find('input').each(function () {
                data[$(this).attr('name')] = $(this).val();
            });

            $btn.prop('disabled', true);
            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function (res) {
                    var $sel = $('select[name="category_id"]');
                    if ($sel.find('option[value="' + res.id + '"]').length === 0) {
                        $sel.append(new Option(res.text, res.id, true, true));
                    }
                    $sel.val(res.id).trigger('change');

                    $('#commonModalOver').modal('hide');
                    if (typeof show_toastr === 'function') {
                        show_toastr('{{ __('Success') }}', res.message || '{{ __('Category created') }}', 'success');
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
