<div class="content-navigation">
    <a href="?controller=domain" class="button green tall">&lt; Get another domain(s) info</a>
</div>

<div id=domains_info>
    <h2>Information about requested domains</h2>

    <?php foreach ($this->info as $info) { ?>
    <div class="clear"></div>
    <details open=open>
        <summary>
            <span>
                <?=htmlspecialchars($info->url, ENT_QUOTES)?>
                [<?=$info->ip_address?>]
                <?=$info->google_results?>
                (<?="{$info->country_name} [{$info->country_code}]"?>)
            </span>
        </summary>
        <div class="summary-content">

            <?php if (!empty($info->external_links)) { ?>
                <ul class=external-links>
                <?php foreach($info->external_links as $link) { ?>
                    <li><a href="<?=$link['url']?>"><?=$link['text']?></a></li>
                <?php } ?>
                </ul>
            <?php } else { ?>
                <h2>Haven't external links</h2>
            <?php } ?>
        </div>
    </details>

    <?php } ?>
</div>
