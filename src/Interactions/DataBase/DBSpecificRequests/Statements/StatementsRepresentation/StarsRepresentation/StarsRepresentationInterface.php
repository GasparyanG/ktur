<?php
namespace DataBase\DBSpecificRequests\Statements\StatementsRepresentation\StarsRepresentation;

use DataBase\Interfaces\TableInterface as TableInterface;

interface StarsRepresentationInterface
{
    public function getSelfPointingUriSegment();

    public function starsTableDefinition();

    public function statementMetadataTableDefinition();

    public function statementPhotosTableDefinition();
}