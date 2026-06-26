@php $faq = $faq ?? null; @endphp
<div class="mb-3"><label class="form-label">Question</label><input name="question" class="form-control" required value="{{ old('question', $faq?->question) }}"></div>
<div class="mb-3"><label class="form-label">Answer</label><textarea name="answer" class="form-control" rows="4" required>{{ old('answer', $faq?->answer) }}</textarea></div>
<div class="mb-3"><label class="form-label">Sort Order</label><input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $faq?->sort_order ?? 0) }}"></div>
<div class="form-check mb-2"><input type="checkbox" name="is_active" value="1" class="form-check-input" @checked(old('is_active', $faq?->is_active ?? true))><label class="form-check-label">Active</label></div>
<div class="form-check"><input type="checkbox" name="is_open_default" value="1" class="form-check-input" @checked(old('is_open_default', $faq?->is_open_default))><label class="form-check-label">Open by default on website</label></div>
