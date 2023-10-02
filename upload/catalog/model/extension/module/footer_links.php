<?php
	class ModelExtensionModuleFooterLinks extends Model {

		public function getFooterLinks($id) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "footer_links WHERE id = '" . (int)$id . "'");

			return $query->row;
		}

		public function getAllFooterLinks($data = array()) {
			$sql = "SELECT * FROM " . DB_PREFIX . "footer_links";

			$sort_data = array(
				'id',
				'name',
				'sort_order',
				'status',
			);

			if (isset($data['status'])) {
				$sql .= " WHERE status = '" . (int)$data['status'] . "'";
			}

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY id";
			}

			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}

			$query = $this->db->query($sql);

			return $query->rows;

		}
	}

