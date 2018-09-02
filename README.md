RDF Datatype (module for Omeka S)
=================================

[RDF Datatype] is a module for [Omeka S] that implements the main [RDF datatypes]
and [XSD datatypes] recommended by the World Wide Web consortium [W3C], so the
values of properties may have a better semanticity, not only the default text,
Omeka resource and URI, but boolean, integer, decimal, date, time, html and xml
too.


Installation
------------

Uncompress files and rename plugin folder `RdfDatatype`.

See general end user documentation for [Installing a module] and follow the
config instructions.


Usage
-----

The data types are automatically available in all the resource forms.
Nevertheless, it is recommended to create resources templates in order to
simplify their use and to normalize the records.

Note: the datatypes `xsd:gMonth`, `xsd:gMonthDay` and `xsd:gDay` may not be
intuitive. To be compliant with the standard, they should be prepended with `--`
for months, and `---` for day. They are not added automatically.


TODO
----

- Use a javascript for xsd:dateTime.
- Use a purifier for rdf:XMLLiteral.
- Add a batch process to change the type of a property for a list of resources.
- Add xsd:token or a derivative for standard or custom enumerations (language, etc.).
- Add xsd:anyURI for uris.
- Normalize Zend form for xsd:time, that requires seconds.
- Simplify search ([Omeka S issue #1241]).
- Manage restrictions via the resource templates (default value for boolean,
  range, default tokens, with or without seconds, css for html, xsl for xml…).


Warning
-------

Use it at your own risk.

It’s always recommended to backup your files and your databases and to check
your archives regularly so you can roll back if needed.


Troubleshooting
---------------

See online issues on the [module issues] page on GitHub.


License
-------

This module is published under the [CeCILL v2.1] licence, compatible with
[GNU/GPL] and approved by [FSF] and [OSI].

This software is governed by the CeCILL license under French law and abiding by
the rules of distribution of free software. You can use, modify and/ or
redistribute the software under the terms of the CeCILL license as circulated by
CEA, CNRS and INRIA at the following URL "http://www.cecill.info".

As a counterpart to the access to the source code and rights to copy, modify and
redistribute granted by the license, users are provided only with a limited
warranty and the software’s author, the holder of the economic rights, and the
successive licensors have only limited liability.

In this respect, the user’s attention is drawn to the risks associated with
loading, using, modifying and/or developing or reproducing the software by the
user in light of its specific status of free software, that may mean that it is
complicated to manipulate, and that also therefore means that it is reserved for
developers and experienced professionals having in-depth computer knowledge.
Users are therefore encouraged to load and test the software’s suitability as
regards their requirements in conditions enabling the security of their systems
and/or data to be ensured and, more generally, to use and operate it in the same
conditions as regards security.

The fact that you are presently reading this means that you have had knowledge
of the CeCILL license and that you accept its terms.


Copyright
---------

* Copyright Daniel Berthereau, 2018


[RDF Datatype]: https://github.com/Daniel-KM/Omeka-S-module-RdfDatatype
[Omeka S]: https://omeka.org/s
[RDF datatypes]: https://www.w3.org/TR/rdf11-concepts/#section-Datatypes
[XSD datatypes]: https://www.w3.org/TR/xmlschema11-2
[W3C]: https://www.w3.org
[installing a module]: http://dev.omeka.org/docs/s/user-manual/modules/#installing-modules
[Omeka S issue #1241]: https://github.com/omeka/omeka-s/issues/1241
[module issues]: https://github.com/Daniel-KM/Omeka-S-module-RdfDatatype/issues
[CeCILL v2.1]: https://www.cecill.info/licences/Licence_CeCILL_V2.1-en.html
[GNU/GPL]: https://www.gnu.org/licenses/gpl-3.0.html
[FSF]: https://www.fsf.org
[OSI]: http://opensource.org
[MIT]: https://github.com/sandywalker/webui-popover/blob/master/LICENSE.txt
[Daniel-KM]: https://github.com/Daniel-KM "Daniel Berthereau"
