<script type="text/javascript">
    $(function() {
        $("form input").keypress(function(e) {
            if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
                $('#submit').click();
                e.preventDefault();
            }
        });
        $("#submit").click(function() {
            var search = $("input#search").val();
            if (search == "") {
                $("input#search").focus();
                return false;
            }

            var datas = 'name=' + search;
            $.ajax({
                type: "POST",
                url:  "/search/submit",
                data: datas,
                success: function(data) {
                    $("#result").html(data);
                }
            });
            return false;
        });
    });
</script>
