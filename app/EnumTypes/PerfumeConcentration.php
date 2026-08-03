<?php

namespace App\EnumTypes;

enum PerfumeConcentration: string
{
    case EDC = "Eau de Cologne";
    case EDT = "Eau de Toilette";
    case EDP = "Eau de Parfum";
    case PARFUM = "Parfum";
    case EXTRAIT = "Extrait de Parfum";
}
