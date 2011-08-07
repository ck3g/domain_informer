<div>
    <form id=domain_form action="?controller=domain&action=show_results" method="post">
        <div id=domains_content>
            <div>
                <?php
                ?>
                <textarea name="domains" class="url-wide" placeholder="Enter list of urls here" rows="15"><?=$this->domains_list?></textarea>
            </div>
        </div>
            <div id=buttons>
                <input type=submit class="button green tall" id=submit value="Get info">
            </div>
            <div id=preloader style="display: none;">
                <img src="<?=SITE_PATH?>/public/images/preloader.gif" alt="loading.." />
            </div>
    </form>
</div>
<script type="text/javascript">
   $(function() {
       $("#submit").click(function() {
           $("#buttons").hide();
           $("#preloader").show();
       });
   });
</script>



