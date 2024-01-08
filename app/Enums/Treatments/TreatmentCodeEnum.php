<?php

namespace App\Enums\Treatments;

use App\Traits\Enum\EnumTrait;
use App\Services\Main\MainService;
use App\Enums\Attributes\Description;
use App\Enums\Attributes\ServiceClass;
use App\Services\Steps\MergeFileStepService;
use App\Services\Steps\ImportFileStepService;
use App\Services\Steps\NotifyFileStepService;
use App\Services\Steps\FormatFileStepService;
use App\Services\Steps\DownloadFileStepService;

enum TreatmentCodeEnum: string
{
    use EnumTrait;

    #[Description('Principal Traitement de Raport')]
    #[ServiceClass(MainService::class)]
    case MAIN = 'main';

    #[Description('Starting Treatment')]
    case STARTING = 'starting';

    #[Description('Ending Treatment')]
    case ENDING = 'ending';

    #region Treatment Steps

    #[Description('Download file Step')]
    #[ServiceClass(DownloadFileStepService::class)]
    case DOWNLOADFILE = 'downloadfile';

    #[Description('Import file Step')]
    #[ServiceClass(ImportFileStepService::class)]
    case IMPORTFILE = 'importfile';

    #[Description('Format file')]
    #[ServiceClass(FormatFileStepService::class)]
    case FORMATFILE = 'formatfile';

    #[Description('Merge File Rows')]
    #[ServiceClass(MergeFileStepService::class)]
    case MERGEFILE = 'mergefile';

    #[Description('Notify file')]
    #[ServiceClass(NotifyFileStepService::class)]
    case NOTIFYFILE = 'notifyfile';
    #endregion

    #region Protocol access
    #[Description('Get protocole disk')]
    case PROTOCOL_DISK_GET = 'protocoldiskget';

    #endregion

    #region Download File
    #[Description('Récupération du mode Action')]
    case DOWNLOADFILE_RETRIEVEMODEACTION_GET = 'downloadfileretrievemodeactionget';

    #[Description('Récupération du mode Action apres execution')]
    case DOWNLOADFILE_RETRIEVEMODEACTION_AFTEREXEC_GET = 'downloadfile_retrievemodeaction_afterexec_get';

    #[Description('Download File By Name')]
    case DOWNLOADFILE_BYNAME = 'downloadfilebyname';

    #[Description('Download File By Wildcard')]
    case DOWNLOADFILE_WILDCARD = 'downloadfile_wildcard';

    #[Description('Delete File')]
    case DOWNLOADFILE_DELETE = 'downloadfiledelete';

    #[Description('Rename downloaded File')]
    case DOWNLOADFILE_RENAME = 'downloadfilerename';

    #endregion

    #region import file
    #[Description('Start Import')]
    case IMPORT_START = 'importstart';

    #[Description('Delete imported data')]
    case IMPORT_DEL = 'importdel';

    #[Description('End import data')]
    case IMPORT_END = 'importend';

    #[Description('Import Data File')]
    case IMPORTDATAFILE_EXEC = 'importdatafileexec';

    #[Description('Import Data Row')]
    case IMPORTDATAROW = 'importdatarow';
    #endregion

    #region format data
    #[Description('Execute Format Data')]
    case FORMATDATA_EXEC = 'formatdata_exec';

    #[Description('Execute Format Data')]
    case FORMATDATAROW = 'formatdatarow';

    #[Description('Init Format Data')]
    case FORMATDATA_INIT = 'formatdatainit';
    #endregion

    #region merge columns
    #[Description('Exec Merge Column')]
    case MERGECOLUMN_EXEC = 'mergecolumnexec';
    #endregion

    #region merge rows

    #[Description('Exec Merge Rows')]
    case MERGEROWS_EXEC = 'mergerowsexec';

    #[Description('Merge Formatted Row')]
    case MERGEFORMATTEDROW = 'mergeformattedrow';

    #[Description('Merge Formatted File')]
    case MERGEFORMATTEDFILE = 'mergeformattedfile';
    #endregion

    #region

    #[Description('File Notifiation Start')]
    case NOTIFYFILE_START = 'notifyfile_start';

    #[Description('File Notifiation End')]
    case NOTIFYFILE_END = 'notifyfile_end';
    #endregion

}
