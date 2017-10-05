SOURCES = AnnoPlugin.inc.php index.php version.xml locale

help:
	@echo "Targets"
	@echo ""
	@echo "  clean"
	@echo "  tarball"

clean:
	rm -fr anno

tarball: clean
	mkdir -p anno
	cp -r $(SOURCES) anno
	tar cvzf anno.tgz anno
	$(MAKE) clean
	@echo "#--\n#-- Built plugin as\n#--\t$(PWD)/anno.tgz\n#--"
