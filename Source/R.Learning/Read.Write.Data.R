# Read tabular data
read.table()
read.csv()
# Read lines of text file
readLines()
# Read R code files
source() # inverse of dump
dget() # inverse of dput
# Load saved workspace
load()
# Read single R objects in binary
unserialize()

write.table()
writeLines()
dump()
dput()
save()
serialize()

# read.table()
# Argulents
# file, header, separator, colClasses, nrows, comment.char, skip, stringsAsFactors
# colClasses is a type specification. Numeric, character, factor, etc
# colClasses is really important with large data sets so R does not have to parse the file twice
# stringsAsFacrors = FALSE: R assumes strings are factor labels. If they are just strings, set to FALSE

data <- read.table("foo.txt")
# the help page for read.table is REALLY helpful
# set comment.char = "" if there are no comments in your file. 

initial <- read.table("data.txt", nrows=100)
# list the initial vectors
classes <- sapply(initial, class)
classes
# view the head of elements in table
head(initial)
# now that you know the classes, read the whole table
tabAll <- read.table("data.txt", colClasses = classes)
head(tabAll)
str(tabAll)

# set nrows to calculate the memory footprint for R. Use wc -l to calculate the # of lines
str(.Platform)

# Calculate memory usage
# rows * columns = total elements
# numeric = 8 bytes per element
# So 1.5m rows * 120 cols, all numeric = 1,440,000,000
# = 1,373 MB, 1.34 GB
# read.table() has overhead, allocate 2x the size or 2.7 GB

# Dump and Dput to SAVE FILES
# keeps R meta data so you don't need to specify every time
# but text giles are better for git/svn use and historical logging
# dput can only handle one object at a time
y <- data.frame(a = 1, b = "a")
dput(y)
dput(y, file = "y.R")
new.y <- dget("y.R")
new.y
# dump lets you save many objects to and from a single file

# Open files and other types
file() # open a file handle
gzfile() #gzip compressed
bzfile() #bzip compressed
url() # web connection

str(file)

connection <- gzfile("words.gz")
x <- readLines(connection, 10)
# read the first 10 lines from the compressed file

# get current dir
getwd()
setwd("/usr/rob/mydir")
dir()
ls()
source("myFunction.R")
options()
history()

# how to use STR()
# display internal R structure of an object
str(ls)
x <- rnorm(100,2,4)
summary(x)
str(x)
x
order(x)

# split a matrix into distinct months
s <- split(airquality, airquality$Month)
# show structure of the 5 separate months
str(s)








