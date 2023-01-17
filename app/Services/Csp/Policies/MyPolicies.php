<?php

namespace App\Services\Csp\Policies;

use Spatie\Csp\Policies\Policy;
use Spatie\Csp\Value;
use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;

class MyPolicies extends Policy
{
    public function configure()
    {
        $this
            ->addDirective(Directive::BASE, Keyword::SELF)
            ->addDirective(Directive::CHILD, Keyword::SELF)
            ->addDirective(Directive::CONNECT, [
                Keyword::SELF,
                '*.baleprasutisingaperbangsa.com',
                'widget.kominfo.go.id',
                'maps.googleapis.com'
            ])
            ->addDirective(Directive::DEFAULT, Keyword::SELF)
            ->addDirective(Directive::FORM_ACTION, Keyword::SELF)
            ->addDirective(Directive::FRAME_ANCESTORS, Keyword::SELF)
            ->addDirective(Directive::IMG, [
                Keyword::SELF,
                'data:',
                'blob:',
                'cdn.dribbble.com',
                'mt0.google.com',
                'mt1.google.com',
                'mt2.google.com',
                'mt3.google.com',
                'api.mapbox.com',
                'maps.googleapis.com',
                'maps.gstatic.com'
            ])
            ->addDirective(Directive::MANIFEST, Keyword::SELF)
            ->addDirective(Directive::MEDIA, Keyword::SELF)
            ->addDirective(Directive::OBJECT, Keyword::NONE)
            ->addDirective(Directive::PREFETCH, Keyword::SELF)
            ->addDirective(Directive::REPORT, 'https://e9b260f07584bece5bb64e0e89f9a847.report-uri.com/r/d/csp/reportOnly')
            ->addDirective(Directive::UPGRADE_INSECURE_REQUESTS, Value::NO_VALUE)
            ->addDirective(Directive::WORKER, Keyword::SELF)
            ->addDirective(Directive::FONT, [
                Keyword::SELF,
                'fonts.googleapis.com',
                'fonts.gstatic.com',
                'cdnjs.cloudflare.com',
            ])
            ->addDirective(Directive::FRAME, [
                Keyword::SELF,
                'www.google.com',
                'widgets.woxo.tech',
                'www.youtube.com'
            ])
            ->addDirective(Directive::SCRIPT, [
                Keyword::SELF,
                Keyword::UNSAFE_INLINE,
                Keyword::REPORT_SAMPLE,
                'www.google.com',
                'www.gstatic.com',
                'cdn.jsdelivr.net',
                'formvalidation.io',
                'cdn.amcharts.com',
                'unpkg.com',
                'api.mapbox.com',
                'cdn2.woxo.tech',
                'widget.kominfo.go.id',
                'maps.googleapis.com'
            ])
            ->addDirective(Directive::STYLE, [
                Keyword::SELF,
                Keyword::UNSAFE_INLINE,
                'fonts.googleapis.com',
                Keyword::REPORT_SAMPLE,
                'cdnjs.cloudflare.com',
                'unpkg.com',
                'api.mapbox.com'
            ]);
    }
}
