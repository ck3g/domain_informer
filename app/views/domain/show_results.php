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
            <td><?=$info->google_results?></td>
        </tr>
        <tr class=links>
            <td colspan=4>
                <br />
                <details>
                    <summary close=close><strong>External Links</strong></summary>
                    <br />
                    <?php if (!empty($info->external_links)) { ?>
                        <ul class=external-links>
                        <?php foreach($info->external_links as $link) { ?>
                            <li><a href="<?=$link['url']?>"><?=$link['text']?></a></li>
                        <?php } ?>
                        </ul>
                    <?php } else { ?>
                        <h2>Haven't external links</h2>
                    <?php } ?>
                    <br />
                </details>
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
