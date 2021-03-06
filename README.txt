EBA: Entity Block Attachment
----------------------------

Choose the block that you wish to show on entities and configure it. You can do
this from its contextual link that admins can see (if available), or from the
main blocks administration page at /admin/structure/block (Structure > Blocks
from the administrative toolbar).

At the bottom of the 'confgure block' form for the block is a tab entitled
'Entity Block Attachment'. Click this and you will see a list of all entity
types and their bundles (bundles are 'subtypes' - such as vocabularies for
taxonomy terms or node types for content). Select those that you want the block
to appear on.

For the Drupal 8 version of the plugin, there is only one visibility settings:
entity bundle. This plugin does not currently respect other block visibility 
settings, since regions are the arbiters of these conditions and this plugin
operates outside the region system.

Once the configure block form is saved, the block will immediately appear on all
view modes (e.g. teasers and search results as well as the full content version)
of the selected types of entities.

The block can be re-ordered amongst the rest of the entity's content, or hidden,
for individual view modes on the "Manage Display" administration page for that
entity type/subtype, which is provided by the Field UI module.

More information
----------------
* The module's project description page:
http://drupal.org/project/eba

* An article about the module:
http://www.computerminds.co.uk/drupal-code/place-blocks-inside-your-content-eba

* The project issue queue (you may wish to raise bugs or requests here if your
query has not been raised by others already):
http://drupal.org/project/issues/eba
