<script>

$(document).ready(
  function () {
    $("span.short").click(
      function() {
        $(this).siblings().show( 800);
      }
    );
    $("span.long").click(
      function() {
        $(this).hide( 800);
      }
    );
    $("span.long").hide();
  }
);

</script>
