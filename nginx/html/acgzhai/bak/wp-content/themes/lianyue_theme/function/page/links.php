<?php 
#安全检测
if (!defined('DB_NAME')) {
	die('theme:http://www.lianyue.org');
}
get_header(); 
?>
<div class="post">
	<div class="left">
		<div  class="page_linsk" id="links">
			<?php
			echo '<h2 class="title breadcrumb">'.wp_breadcrumb().'</h2>';
			
			global $wpdb; 
			$sql = "SELECT * FROM {$wpdb->term_taxonomy} taxonomy 
					INNER JOIN {$wpdb->terms} term  ON taxonomy.term_id = term.term_id 
					WHERE 1=1 
					AND taxonomy.taxonomy = 'link_category'
					";
			$links_cat = $wpdb->get_results ($sql);
			$arr_link['hide_invisible'] = 0;
			$arr_link['orderby'] = 'link_id';
			$arr_link['order'] = 'ASC';
			$links_html ='';
			$hide = array();
			foreach ( $links_cat as $value ) {
				$arr_link['category'] = $value->term_id;
				$bookmarks = get_bookmarks($arr_link);
				$links_html.= "<h2 class=\"link_cat\">{$value->name}</h2>";
				$links_html.= "<table><thead><tr>";
				$links_html.= "<td class=\"ico\">ICO</td>";
				$links_html.= "<td class=\"name\">链接名称</td>";
				$links_html.= "<td class=\"url\">链接地址</td>";
				$links_html.= "<td class=\"description\">链接描述</td>";
				$links_html.= "</tr></thead>";
				foreach ( $bookmarks as $bm ) {
					if($bm->link_visible =='N'){
						$hide[$bm->link_id] = $bm;
					}else{
						$links_html.= "<tr>";
						$links_html.= "<td class=\"ico\"><img src=\"http://203.208.46.255/s2/favicons?domain_url={$bm->link_url}\"></td>";
						$links_html.= "<td class=\"name\"><a href=\"{$bm->link_url}\"  rel=\"friend\"  title=\"{$bm->link_description}\" target=\"_blank\">{$bm->link_name}</a></td>";
						$links_html.= "<td class=\"url\"><a href=\"{$bm->link_url}\"  rel=\"friend\"  title=\"{$bm->link_description}\" target=\"_blank\">{$bm->link_url}</a></td>";
						$links_html.= "<td class=\"description\">{$bm->link_description}&nbsp;</td>";
						$links_html.= "</tr>";
					}
				}
				$links_html.= "</table>";
			}
		
			$links_html.= "<h2 class=\"link_cat\">没审核的链接</h2>";
			$links_html.= "<table><thead><tr>";
			$links_html.= "<td class=\"ico\">ICO</td>";
			$links_html.= "<td class=\"name\">链接名称</td>";
			$links_html.= "<td class=\"url\">链接地址</td>";
			$links_html.= "<td class=\"description\">链接描述</td>";
			$links_html.= "</tr></thead>";
			foreach ( $hide as $bm ) { 
					$links_html.= "<tr>";
					$links_html.= "<td class=\"ico\"><img src=\"http://203.208.46.255/s2/favicons?domain_url={$bm->link_url}\"></td>";
					$links_html.= "<td class=\"name\"><a href=\"{$bm->link_url}\"  rel=\"friend\"  title=\"{$bm->link_description}\" target=\"_blank\">{$bm->link_name}</a></td>";
					$links_html.= "<td class=\"url\"><a href=\"{$bm->link_url}\"  rel=\"friend\"  title=\"{$bm->link_description}\" target=\"_blank\">{$bm->link_url}</a></td>";
					$links_html.= "<td class=\"description\">{$bm->link_description}&nbsp;</td>";
					$links_html.= "</tr>";
			}
			$links_html.= "</table>";
			 echo $links_html; 
			 
			 
			 
			 ?>

			
		</div>
	</div>
	<?php get_sidebar(); ?>
	<div class="clear"></div>
</div>
<?php get_footer(); ?>