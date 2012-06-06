PUNCH=~/node_modules/punch/bin/punch

default: config.json	#default target makes website with punch, depends on config.json
     $(punch) .    
