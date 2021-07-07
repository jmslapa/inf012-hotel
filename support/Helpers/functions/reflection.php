<?php

if (!function_exists('calledByClass')) {
    /**
     * Verifica se a função foi invocada direta ou indiretamente por uma classe específica.
     *
     * @param string $class Classe alvo da verificação.
     * @return boolean
     */
    function calledByClass(string $class): bool
    {
        return (bool) collect(debug_backtrace())->filter(
            fn($el) =>
                isset($el['class'])
                && $el['class'] === $class
        )->count();
    }
}
