@props([
    'question',
    'answer',
    'active' => false,
])

<div @class(['faq-item', 'active' => $active])>
	<button class="faq-question" type="button">{{ $question }} <i class="fa-solid fa-chevron-down"></i></button>
	<div class="faq-answer"><div class="faq-answer-inner">{{ $answer }}</div></div>
</div>
