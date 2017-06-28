$().ready(function() {
    $('#menu li a').hover(
        function() {
            $(this).animate({'padding-left': '15px'}, 250, 'linear');
        },
        function() {
            $(this).animate({'padding-left': '5px'}, 250, 'linear');
        }
    );
    $("button, input:submit, a.button").button();
});
