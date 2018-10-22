<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * Enumerated type of the available sheets to be imported from the legacy
 * system.  The indices of the identifiers will match the index of the language
 * in the `Languages` enumerated type.
 */
final class Sheets extends Enum
{
    const Assess = [
        Languages::English => '1-uI8poRMsq_PG2q-hMqQ1e7619_NA6d75M_xhTeVuZA',
        Languages::French => '1F60GcPS7q7_w-MP_jXlyM6_yVKjtCECtei1LZdp1u7c',
    ];
    const Mbct = [
        Languages::English => '1ZgNkkicFLibcNJ_rrMSc5oZT29SsfLteRbvWMC1mRLQ',
        Languages::French => '1_83nwqOLX_Hf4TWHugo92_kJyrq3GjKYxR02jhONoIY',
    ];
    const Mbsr = [
        Languages::English => '1MMWfbhcqejWueBCUvlVMZSiT7XmqIouYWak-s8duQCg',
        Languages::French => '1pIDhgUPFKA-D0iwQbJV17Dngc82J3bjay6n7Rx2VLS0',
    ];
}
