<div class="content-navigation">
    <a href="?controller=domain" class="button green tall">&lt; Get another domain(s) info</a>
</div>

<div id=domains_info>
    <h2>Information about requested domains</h2>

    <div class="clear"></div>
    <table class=results-table>
    <?php foreach ($this->info as $info) { ?>
        <tr class=head>
            <th>Url</th>
            <th>Country</th>
            <th>IP Address</th>
            <th>Google Results</th>
        </tr>
        <tr class=body>
            <td><?=htmlspecialchars($info->url, ENT_QUOTES)?></td>
            <td><?=$info->country_code?></td>
            <td><?=$info->ip_address?></td>
            <td><?=empty($info->google_results) ? '-' : $info->google_results?></td>
        </tr>
        <tr class=links>
            <td colspan=4>
                <br />
                <a href="javascript://" class="show-links">External links...</a>
                <div class="links-list" style="display: none;">
                    <br />
                    <?php if (!empty($info->external_links)) { ?>
                        <table class="external-links">
                            <tr>
                                <th>Keyword</th>
                                <th style="margin-left: 20px;">Url</th>
                            </tr>
                        <?php foreach($info->external_links as $link) { ?>
                            <tr>
                                <td><?=$link['text']?>&nbsp;&nbsp;&nbsp;</td>
                                <td><?=$link['url']?></td>
                            </tr>
                        <?php } ?>
                        </table>
                    <?php } else { ?>
                        <h2>Haven't external links</h2>
                    <?php } ?>
                    <br />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <br />
            </td>
        </tr>
    <?php } ?>
    </table>
</div>
<script type="text/javascript">
    $(function() {
        $("a.show-links").click(function() {
            $(this).next("div.links-list").toggle();
        });
    });
</script>
