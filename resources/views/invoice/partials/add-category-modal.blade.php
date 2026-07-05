{{-- Inline "Add Category" modal. Injects into the category dropdown via AJAX
     without leaving the page. Pass ['categoryType' => 'expense'] when
     including on expense-side forms (bill/expense/purchase/payment);
     defaults to 'income' (proposal/revenue/invoice). --}}
@php $categoryType = $categoryType ?? 'income'; @endphp
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">{{ __('Add Category') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="addCategoryError"></div>
                <div class="row" id="addCategoryForm">
                    <input type="hidden" name="type" value="{{ $categoryType }}">
                    <div class="col-md-8 form-group">
                        <label class="form-label">{{ __('Name') }}<x-required></x-required></label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="form-label">{{ __('Color') }}<x-required></x-required></label>
                        <input type="color" class="form-control form-control-color" name="color" value="#6777ef">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="button" class="btn btn-primary" id="saveNewCategory">{{ __('Save Category') }}</button>
            </div>
        </div>
    </div>
</div>

@push('script-page')
    <script>
        (function () {
            var url = '{{ route('product-category.store.ajax') }}';

            function tokenVal() {
                return document.getElementById('token') ? document.getElementById('token').value : '{{ csrf_token() }}';
            }

            $(document).on('click', '#saveNewCategory', function () {
                var $btn = $(this);
                var $err = $('#addCategoryError').addClass('d-none').text('');
                var data = { _token: tokenVal() };
                $('#addCategoryForm').find('input').each(function () {
                    data[$(this).attr('name')] = $(this).val();
                });

                $btn.prop('disabled', true);
                $.ajax({
                    url: url,
                    type: 'POST',
                    headers: { 'X-CSRF-TOKEN': tokenVal() },
                    data: data,
                    success: function (res) {
                        var $sel = $('select[name="category_id"]');
                        if ($sel.find('option[value="' + res.id + '"]').length === 0) {
                            $sel.append(new Option(res.text, res.id, true, true));
                        }
                        $sel.val(res.id).trigger('change');

                        var m = bootstrap.Modal.getInstance(document.getElementById('addCategoryModal'));
                        if (m) m.hide();
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
@endpush
