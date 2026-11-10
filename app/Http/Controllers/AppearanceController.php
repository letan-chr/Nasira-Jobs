<?php

namespace App\Http\Controllers;

use App\Services\AppearanceManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Laracasts\Flash\Flash;

class AppearanceController extends AppBaseController
{
    public function __construct(
        private readonly AppearanceManager $appearance,
    ) {}

    public function index(): View
    {
        return view('appearance.index', [
            'tokens' => $this->appearance->tokens(),
            'defaults' => $this->appearance->defaults(),
            'schema' => $this->appearance->schema(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $tokenMeta = collect(config('appearance.token_meta', []));

        $colorKeys = $tokenMeta
            ->filter(fn (array $meta) => ($meta['type'] ?? null) === 'color')
            ->keys()
            ->all();

        $pxKeys = $tokenMeta
            ->filter(fn (array $meta) => ($meta['type'] ?? null) === 'px')
            ->keys()
            ->all();

        $rules = [
            'tokens' => ['required', 'array'],
            'tokens.font-sans' => ['required', 'string', Rule::in(array_keys(config('appearance.fonts', [])))],
        ];

        foreach ($colorKeys as $key) {
            $rules["tokens.{$key}"] = ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'];
        }

        foreach ($pxKeys as $key) {
            $meta = $tokenMeta->get($key, []);
            $min = (int) ($meta['min'] ?? 8);
            $max = (int) ($meta['max'] ?? 72);

            $rules["tokens.{$key}"] = [
                'required',
                'string',
                'regex:/^\d+(\.\d+)?px$/',
                function (string $attribute, mixed $value, \Closure $fail) use ($min, $max): void {
                    $number = (float) str_replace('px', '', (string) $value);

                    if ($number < $min || $number > $max) {
                        $fail("The {$attribute} must be between {$min}px and {$max}px.");
                    }
                },
            ];
        }

        $validated = $request->validate($rules);

        $this->appearance->update($validated['tokens']);

        Flash::success('Appearance settings saved.');

        return Redirect::route('appearance.index');
    }

    public function reset(): RedirectResponse
    {
        $this->appearance->reset();

        Flash::success('Appearance reset to defaults.');

        return Redirect::route('appearance.index');
    }
}
