grep() # return the matching indicies in a vector. If you have a 10 word list and the 4th word
# matched, return 4
grepl() # return a T/F logical vector for matching elements
regexpr()
gregexpre()
sub()
gsub()
regexec()


a <- c("Nine", "out", "of", "ten", "will", "polinate", ".")
grep("of", a)
grep("sadfasdfa", a)
length(grep("sadfasdfa", a)) 
length(grep("Nine", a))