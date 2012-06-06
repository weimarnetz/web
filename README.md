# Weimarnetz + Punch = <3

this is the refactoring branch for moving the weimarnetz.de website from (simple) php to (the awesome) [punch](https://github.com/laktek/punch)

as of now, it's not as DRY as it could be, but we take the oppertunity to migrate so we can give [feedback](https://github.com/laktek/punch/pull/2) to the developer


## dir structure

- contents: content for every page in ``.json`` or ``.markdown`` (html is valid markdown)
- templates: templates for every page in ``.mustache`` (html is valid mustache)
- shared templates: start with '_', like ``_header.mustache``


## page structure

    +---------------------------------+
    |  _pre.mustache (start of html)  |
    +---------------------------------+
    |  _header.mustache (header)      |
    +---------------------------------+
    |  PAGE-SPECIFIC CONTENT          |
    |  (everything IN <container>)    |
    +---------------------------------+
    |  footer.mustache (footer)       |
    +---------------------------------+
    |  _post.mustache (end of html)   |
    +---------------------------------+