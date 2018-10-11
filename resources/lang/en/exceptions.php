<?php

return [
    'DigitalSignatureInvalidException' => [
        'message' => 'Your digital signature does not match our records.',
    ],
    'NoAvailableQuestionnairesException' => [
        'message' => 'There are no questionnaires available to assign to this client.',
    ],
    'QuestionnaireAlreadyAssignedException' => [
        'message' => 'This questionnaire is already assigned to the client.',
    ],
    'QuestionnaireAlreadyCompletedException' => [
        'message' => 'This questionnaire is completed so the requested action is not allowed.',
    ],
];
