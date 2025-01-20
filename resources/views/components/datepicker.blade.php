@props(['name', 'defaultDate' => now()->format('Y-m-d')])

<div>
    <input
        type="date"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $defaultDate) }}"
        class="form-input w-full border-gray-300 rounded-md shadow-sm"
        onchange="updateReport()"
    />
</div>
