/**
 * @author nikita.vanyasin@gmail.com
 * Apache 2.0 license
 *
 * @description Based on http://stackoverflow.com/a/15544117
 * Adds method to jQuery object:
 *
 * @example .numberField(options)
 * where options is (you can pass any or no options):
 * {
 *     ints: 2,         // digits count to the left from separator
 *     floats: 6,       // digits count to the right from separator
 *     separator: "."
 * }
 *
 */
(function( $ )
{
    $.fn.numberField = function( options )
    {
        if ( !options )
        {
            options = {};
        }
        var defaultOptions = {ints: 2, floats: 6, separator: "."};
        options = $.extend( defaultOptions, options );
        var intNumAllow = options.ints;
        var floatNumAllow = options.floats;
        var separator = options.separator;
        $( this ).on( 'keydown keypress keyup paste input', function()
        {
            while ( (this.value.split( separator ).length - 1) > 1 )
            {
                this.value = this.value.slice( 0, -1 );
                if ( (this.value.split( separator ).length - 1) <= 1 )
                {
                    return false;
                }
            }
		    var re = new RegExp('[^0-9' + options.separator + ']', 'g');
            this.value = this.value.replace(re, '');
			
            var allowedLength;
            var iof = this.value.indexOf( separator );
            if ( (iof != -1) && (this.value.substring( 0, iof ).length > intNumAllow) )
            {
                allowedLength = 0;
            }
            else if ( iof != -1 )
            {
                allowedLength = iof + floatNumAllow + 1;
            }
            else
            {
                allowedLength = intNumAllow;
            }
            this.value = this.value.substring( 0, allowedLength );
            return true;
        } );
        return $( this );
    };
})( jQuery );
