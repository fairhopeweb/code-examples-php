<?php

namespace Example\Controllers\Examples\Admin;

use Example\Controllers\AdminApiBaseController;
use Example\Services\Examples\Admin\BulkImportUserDataService;

class EG004BulkImportUserData extends AdminApiBaseController
{
    const EG = 'aeg004'; # reference (and url) for this example

    const FILE = __FILE__;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        parent::controller();
    }

    /**
     * Check the access token and call the worker method
     * @return void
     * @throws ApiException for API problems.
     * @throws \DocuSign\Admin\Client\ApiException
     */
    public function createController(): void
    {
        $this->checkDsToken();

        $organizationId = $this->clientService->getOrgAdminId();

        // Call the worker method
        $bulkImport = BulkImportUserDataService::bulkImportUserData($this->clientService, $organizationId, $GLOBALS["DS_CONFIG"]["signer_email"]);

        if ($bulkImport) {
            $_SERVER["REQUEST_METHOD"] = 'POST';
            header('Location: ' . $GLOBALS['app_url'] . 'index.php?page=aeg004a');
        }
    }
    
    /**
     * Get specific template arguments
     * @return array
     */
    public function getTemplateArgs(): array
    {
        return $this->getDefaultTemplateArgs();
    }
}
