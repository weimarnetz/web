punch = punch
# if punch can't be found, give the path here:
#punch = /Users/mfa/node_modules/punch/bin/punch

#default target makes website with punch
default:
	$(punch) g 
