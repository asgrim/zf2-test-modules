<?php

namespace Album\Model;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

class AlbumTable
{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}

	public function fetchAll()
	{
		$resultSet = $this->tableGateway->select();
		return $resultSet;
	}

	public function fetchAlbumsForSale()
	{
		$resultSet = $this->tableGateway->select(function (Select $select) {
			$select->where('for_sale', 1);
		});
		return $resultSet;
	}

	/**
	 * @param \DateTime $from
	 * @param \DateTime $to
	 * @return ResultSet
	 */
	public function fetchAlbumsForSaleWithReleaseDatesBetween(\DateTime $from, \DateTime $to)
	{
		$sfrom = $from->format("Y-m-d H:i:s");
		$sto = $to->format("Y-m-d H:i:s");

		$resultSet = $this->tableGateway->select(function (Select $select) use($sfrom, $sto) {
			$select->where->between('release_date', $sfrom, $sto);
			$select->where('for_sale', 1);
		});
		return $resultSet;
	}

	public function getAlbum($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}

	public function saveAlbum(Album $album)
	{
		$data = array(
				'artist' => $album->artist,
				'title'  => $album->title,
		);

		$id = (int)$album->id;
		if ($id == 0) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->getAlbum($id)) {
				$this->tableGateway->update($data, array('id' => $id));
			} else {
				throw new \Exception('Form id does not exist');
			}
		}
	}

	public function deleteAlbum($id)
	{
		$this->tableGateway->delete(array('id' => $id));
	}
}