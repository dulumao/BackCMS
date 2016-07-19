<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        \Blade::directive( 'continue', function ( $expression ) {
            return '<?php continue; ?>';
        } );

        \Blade::directive( 'break', function ( $expression ) {
            return '<?php break; ?>';
        } );

        \Blade::directive( 'ifempty', function ( $expression ) {
            return "<?php if(count$expression == 0): ?>";
        } );

        // Add @endifempty for Loops
        \Blade::directive( 'endifempty', function ( $expression ) {
            return '<?php endif; ?>';
        } );

        \Blade::directive( 'optional', function ( $expression ) {
            return "<?php if(trim(\$__env->yieldContent{$expression})): ?>";
        } );

        // Add @endoptional for Complex Yielding
        \Blade::directive( 'endoptional', function ( $expression ) {
            return "<?php endif; ?>";
        } );

        /*Blade::directive('set', function($expression)
        {
            // Strip Open and Close Parenthesis
            if(Str::startsWith($expression, '('))
                $expression = substr($expression, 1, -1);

            // Break the Expression into Pieces
            $segments = explode(',', $expression, 2);

            // Return the Conversion
            return "<?php " . $segments[0] . " = " . $segments[1] . "; ?>";
        });*/
        /*
         * Laravel dd() function.
         *
         * Usage: @dd($variableToDump)
         */
        \Blade::directive( 'dd', function ( $expression ) {
            return "<?php dd(with{$expression}); ?>";
        } );

        /*
         * php explode() function.
         *
         * Usage: @explode($delimiter, $string)
         */
        \Blade::directive( 'explode', function ( $argumentString ) {
            list( $delimiter, $string ) = $this->getArguments( $argumentString );

            return "<?php echo explode({$delimiter}, {$string}); ?>";
        } );

        /*
         * php implode() function.
         *
         * Usage: @implode($delimiter, $array)
         */
        \Blade::directive( 'implode', function ( $argumentString ) {
            list( $delimiter, $array ) = $this->getArguments( $argumentString );

            return "<?php echo implode({$delimiter}, {$array}); ?>";
        } );

        /*
         * php var_dump() function.
         *
         * Usage: @var_dump($variableToDump)
         */
        \Blade::directive( 'varDump', function ( $expression ) {
            return "<?php var_dump(with{$expression}); ?>";
        } );

        \Blade::directive( 'set', function ( $argumentString ) {
            list( $name, $value ) = $this->getArguments( $argumentString );

            return "<?php {$name} = {$value}; ?>";
        } );

        \Blade::directive( 'permission', function ( $expression ) {
            return "<?php if(Auth('admin')->user()->can($expression)): ?>";
        } );

        \Blade::directive( 'endpermission', function () {
            return "<?php endif; ?>";
        } );

        \Blade::directive( 'welcome', function () {
            return "<?php echo View('welcome')->render(); ?>";
        } );

        \Blade::directive( 'template', function ( $argumentString ) {
            $templateNames = str_replace( [ '(', ')' ], null, $argumentString );
            $template      = \App\Template::whereName( $templateNames )->first();
            $template      = \Addons::templates()->getCompile( $template->code );

            return "<?php \necho <<<Eof\n$template\nEof;\n?>";
        } );
    }

    private function getArguments( $argumentString )
    {
        return explode( ', ', str_replace( [ '(', ')' ], '', $argumentString ) );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
