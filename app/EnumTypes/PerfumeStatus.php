<?php

namespace App\EnumTypes;

enum PerfumeStatus: string
{
    case IN_USE = "em uso";
    case FINISHED = "finalizado";
    case ARCHIVED = "arquivado"; // caso o perfume acabou, mas já fez parte do estoque do usuário
}
