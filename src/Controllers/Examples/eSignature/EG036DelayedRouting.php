<?php

/**
 * Example 036: Delayed Routing.
 */

namespace Example\Controllers\Examples\eSignature;

use Example\Controllers\eSignBaseController;
use Example\Services\Examples\eSignature\DelayedRoutingService;

class EG036DelayedRouting extends eSignBaseController
{
    const EG = 'eg036'; # reference (and URL) for this example
    const FILE = __FILE__;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        parent::controller();
    }

    /**
     * 1. Check the token
     * 2. Call the worker method
     * 3. Redirect the user to the signing
     *
     * @return void
     */
    public function createController(): void
    {
        $this->checkDsToken();
        # 2. Call the worker method
        # More data validation would be a good idea here
        # Strip anything other than characters listed
        $envelopeId = DelayedRoutingService::SendEnvelopeWithDelayedRouting($this->args, $this->clientService, $this::DEMO_DOCS_PATH);

        if ($envelopeId) {
            $_SESSION["envelope_id"] = $envelopeId["envelope_id"]; # Save for use by other examples
                                                                # which need an envelope_id
            $this->clientService->showDoneTemplate(
                "Envelope sent",
                "Envelope sent",
                "The envelope has been created and sent!<br/> Envelope ID {$envelopeId["envelope_id"]}."
            );
        }
    }

    /**
     * Get specific template arguments
     *
     * @return array
     */
    public function getTemplateArgs(): array
    {
        $envelope_args = [
            'signer1_email' => $this->checkEmailInputValue($_POST['signer1Email']),
            'signer1_name' => $this->checkInputValues($_POST['signer1Name']),
            'signer2_email' => $this->checkEmailInputValue($_POST['signer2Email']),
            'signer2_name' => $this->checkInputValues($_POST['signer2Name']),
            'delay' => $this->checkInputValues($_POST['delay']),
            'status' => 'sent'
        ];
        return [
            'account_id' => $_SESSION['ds_account_id'],
            'base_path' => $_SESSION['ds_base_path'],
            'ds_access_token' => $_SESSION['ds_access_token'],
            'envelope_args' => $envelope_args
        ];
    }
}
