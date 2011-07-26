<div>
    <form id=domain_form action="?controller=domain&action=show_results" method="post">
        <div id=domains_content>
            <div>
                <input type=text name=domains[] placeholder="Enter url here" class="url-wide" />
            </div>
        </div>
            <div id=buttons>
                <input type=submit class="button green tall" id=submit value="Get info">
                <input type=button class="button blue tall" id=add_domain value="Add domain">
            </div>
            <div id=preloader style="display: none;">
                <img src="<?=SITE_PATH?>/public/images/preloader.gif" alt="loading.." />
            </div>
    </form>
</div>
<script type="text/javascript">
   $(function() {
       $("#add_domain").click(function() {
           var input = '<input type=text name=domains[] placeholder="Enter url here" class="url-wide" />';
           var link = '<a href="javascript://" class="button blue tall remove_input" tabindex="-1">-</a>';
           $("#domains_content").append('<div>' + input + link + '</div>');
       });

       $(".remove_input").live('click', function() {
           var $this = $(this);
           $this.closest("div").remove();
       });

       $("#submit").click(function() {
           $("#buttons").hide();
           $("#preloader").show();
       });
   });
</script>



