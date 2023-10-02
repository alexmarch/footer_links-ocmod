<?php
	class ModelExtensionModuleFooterLinks extends Model {

		public function getFooterLink($id) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "footer_links WHERE id = '" . (int)$id . "'");

			return $query->row;
		}

		public function getAllFooterLinks($data = array()) {
			$sql = "SELECT * FROM " . DB_PREFIX . "footer_links";

			$sort_data = array(
				'id',
				'text',
				'sort_order',
				'status',
			);

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

		public function addFooterLink($data) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "footer_links SET sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['link_status'] . "', text = '" . $this->db->escape($data['link_text']) . "', link = '" . $this->db->escape($data['link_href']) . "'");

			$id = $this->db->getLastId();

			return $id;
		}

		public function editFooterLink($id, $data) {
			$this->db->query("UPDATE " . DB_PREFIX . "footer_links SET sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['link_status'] . "', text = '" . $this->db->escape($data['link_text']) . "', link = '" . $this->db->escape($data['link_href']) . "' WHERE id = '" . (int)$id . "'");
		}

		public function deleteFooterLinks($id) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "footer_links WHERE id = '" . (int)$id . "'");
		}

		public function getTotalFooterLinkss() {
			$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "footer_links");

			return $query->row['total'];
		}

	}

