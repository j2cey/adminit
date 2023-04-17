<?php

namespace App\Enums;

use App\Traits\Enum\EnumTrait;
use App\Enums\Attributes\Description;

enum HtmlTagKey: string
{
    use EnumTrait;

    #[Description('Tableau')]
    case TABLE = 'table';

    #[Description('Ligne de Tableau')]
    case TABLE_ROW = 'table_row';

    #[Description('Colonne de Tableau')]
    case TABLE_COL = 'table_col';

    #[Description('Gras')]
    case BOLD = 'bold';

    #[Description('Italique')]
    case ITALIC = 'italic';

    #[Description('Souligne')]
    case UNDERLINE = 'underline';
}
