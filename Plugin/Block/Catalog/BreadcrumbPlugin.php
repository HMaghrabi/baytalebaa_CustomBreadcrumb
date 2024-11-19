<?php
namespace Baytalebaa\CustomBreadcrumb\Plugin\Block\Catalog;

use Magento\Catalog\Block\Breadcrumbs;
use Magento\Framework\App\Request\Http;

class BreadcrumbPlugin
{
    protected $request;

    public function __construct(
        Http $request
    ) {
        $this->request = $request;
    }

    public function afterGetCrumbs(Breadcrumbs $subject, $result)
    {
        // Limit to last 2 pages
        if (count($result) > 2) {
            $lastTwoCrumbs = array_slice($result, -2);
            $priorCrumbs = array_slice($result, 0, -2);

            // Transform prior crumbs to compact representation
            $compactCrumbs = array_map(function($crumb) {
                return [
                    'label' => '...',
                    'link' => $crumb['link'] ?? null,
                    'is_compact' => true
                ];
            }, $priorCrumbs);

            $result = array_merge($compactCrumbs, $lastTwoCrumbs);
        }

        return $result;
    }
}