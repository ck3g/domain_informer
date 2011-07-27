<?php

 
class Domain {
    private $info;
    private $url;
    private $external_links = array();

    private $exceptions = array();

    public function __construct($url = '') {
        $this->url = str_replace(' ', '', $url);

        $this->exceptions = array(
            'javascript://'
        );
    }

    public function SetUrl($url) {
        $this->url = $url;
    }

    public function GetInfo() {
        $this->info->url = $this->url;
        $this->info->ip_address = gethostbyname($this->GetWithSubDomain());
        $this->info->google_results = $this->GetGoogleResults();
        $this->info->external_links = $this->GetListOfExternalLinks();

        $geoip = geoip_open(PHP_ROOT . '/lib/geoip/GeoIP.dat', GEOIP_STANDARD);
        $this->info->country_name = geoip_country_name_by_addr($geoip, $this->info->ip_address);
        $this->info->country_code = geoip_country_code_by_addr($geoip, $this->info->ip_address);
        geoip_close($geoip);

        return $this->info;
    }

    private function GetGoogleResults() {
        //http://www.google.com/#source=hp&q=site:homebugh.info
        //http://www.google.com/search?q=cats

        $content = file_get_contents( 'http://209.85.148.105/search?q=site:' . $this->Get() );

        preg_match( '/id=resultStats\>(?<results>[A-Za-z0-9-.,\s]*)/', $content, $matches );
        if (count( $matches ) && isset( $matches['results'] ))
            return $matches['results'];
        
        return '';
    }

    private function Get( $without_protocol = true, $url = null ) {
        if ($url === null)
            $url = $this->url;

        $url = str_replace(' ', '', $url);

        if (!$without_protocol) {
            if ($this->IncludesProtocol($url))
                return $url;
            else
                return 'http://' . $url;

        }

        return preg_replace('/\w+\:\/\//', '', $url);
    }

    private function IncludesProtocol( $url = null ) {
        if ($url === null)
            $url = $this->url;

        return preg_match( '/\w+\:\/\//', $url );
    }

    public function GetDomainOnly($url = null) {
        if ($url === null)
            $url = $this->url;

        $domain_pieces = explode('.', $this->GetWithSubDomain($url));
        return $domain_pieces[count($domain_pieces) - 2] . '.' . $domain_pieces[count($domain_pieces) - 1];
    }

    public function GetWithSubDomain($url = null) {
        if ($url === null)
            $url = $this->url;

        $pieces = explode( '/', $this->Get(true, $url));
        return $pieces[0];
    }

    private function GetListOfExternalLinks() {
        $html = file_get_html( $this->Get( false ) );
        if (!$html)
            return array();

        $html->find( 'a' );

        $links = array();
        foreach ($html->find( 'a' ) as $a) {
            if ($this->IsLinkExternal( $a->href )) {

                $a_innertext = $a->innertext;

                $img_html = str_get_html( $a_innertext );
                if ($img_html !== false) {
                    $img = $img_html->find( 'img', 0 );

                    if (isset( $img->src )) {
                        if (!$this->IsLinkExternal( $img->src ))
                            if (!$this->IncludesProtocol($img->src))
                                $img->src = $this->Get( false ) . $img->src;

                        $a_innertext = $img;
                    }
                }
                $links[] = array( 'url' => $a->href, 'text' => $a_innertext );
            }
        }

        return $links;
    }

    private function IsLinkExternal( $link ) {
        if (in_array($link, $this->exceptions))
            return false;

        $includes_domain = preg_match( '/' . $this->GetWithSubDomain() . '/', $link );
        $includes_protocol = $this->IncludesProtocol( $link );

        if ($includes_domain)
            return false;

        if ($includes_protocol && !$includes_domain)
            return true;

        return false;
    }

}
