# Assign 3 to the object x 
x <- 3
# Assign numbers to a vector (creates length 17)
x <- 3:19
x <- c(5:26) # c() is the concatenate function
x <- c('one', 'two', 'three')
print(x[2])
x
y <- c(TRUE, 2)
print(y)  

# Create Matrix
m <- matrix(1:6, nrow = 2, ncol = 3)
m
# Matrices are filles vertically, by columns. 
# You can also create a vector first then apply dimensions to create the matrix
m <- 1:10
m
dim(m) <- c(2,5)
m
# You can also bind cols and rows
a <- 1:3
b <- 10:12
m <- cbind(a,b)
m
m <- rbind(a,b)
m

# Lists (can have objects of different classes)
# Lists are indexed with double brackets [[ ]], a good way to identify them
x <- list(1, "a", T, 1 + 4i)
x

# Factors 
# Represent categorical data, like data with a label 
# Think of them like an integer vector where each int has a label
# Can be ordered or unordered
# (Full professor, Associate professor, Assistant professor) an ordered list of categories 
# (male, female) an unordered list
# Useful because they are self describing. Male/Female is more clear than 1/2. Coding is built in

f <- factor(c("yes", "yes", "no", "yes", "no"))
f
table(f)
unclass(f)
attr(f,"levels")
# You can set the levels. Here we want Yes to be the first level and No to be the second level
f <- factor(c("yes", "yes", "no", "yes", "no"), levels = c("yes", "no"))
f

# Search for missing values (like NULL in python)
is.na() # test for missing
is.nan() # test for not a number

x <- c(1,2,NA,10,3)
is.na(x)
is.nan(x)
x <- c(1,2,NA,NaN,3)
is.na(x)
is.nan(x)

# Data Frames store tabular data (like a special list)
# Every element must have the same length (same number of elements)
# Each column can be a different type
# Can have row names row.names
# Often created with read.table() or read.csv()
# Can convert to matrix, but will coerce data types to the LCD. data.martix()

x <- data.frame(foo = 1:4, bar = c(T,T,F,T))
x
nrow(x)
ncol(x)

# All objects can have names
x <- 1:3
names(x)
names(x) <- c("foo", "bar", "norf")
names(x)

# lists can have names
x <- list(a = 1, b = 2, c = 3)
x

# Matrices can have names
m <- matrix(1:4, nrow = 2, ncol = 2)
dimnames(m) 
dimnames(m) <- list(c("a", "b"), c("c", "d"))
dimnames(m) 
m

# SUBSETS of vectors, lists, matrices, etc
# The [ will always return an object of the same class as the original. Can select more than 1 element
# The [[ works with lists and data frames. Objects may not be lists or DF's. Only single elements are returned
# $ is used to extract elements by name. Semantics are like the [[ operator

x <- c("a", "b", "c", "c", "d", "a")
x[1]
x[2]
x[1:4]
x[x > "a"]
y <- x > "a" # Creating a logical vector based on the values of x (T, F)
y  
x[y] # Now we can apply the logical vector to the original 

m <- matrix(1:6, 2, 3)
m
m[1,]
m[,2]
m[2,3]
# When a single matrix element is returned, it is returned as a vector instead of a 1x1 matrix. 
# Disable this behavior with drop = FALSE (preserves two dimensions)
m[2,3, drop = FALSE]            
m[1,, drop = FALSE]

x <- list(foo = 1:4, bar = 0.6)
x[1] # from a list, returns a list
x[[1]] # returns just the sequence
x$foo[1] # returns position 1 of named item foo
x$bar # returns the value of element bar
x["bar"] # from a list, returns a list with the single element bar
# calling by name is nice because you don't need to remember position in the list, matric, etc. 

# [[ and $ do not return more than 1 element
# Only [ returns more than 1 element. 
x <- list(foo = 1:4, bar = 0.6, baz = "hello")
x[c(1,3)]

# If the names of your elements were computed by a function, you may not know what they are to call them
# [[ can be used with computed indices; $ can only be used with literal names. 
x <- list(foo = 1:4, bar = 0.6, baz = "hello")
name = "foo"
x[[name]] # works
x$name # does not work
x$foo # works

x <- list(a = list(10, 12, 14), b = c(3.14, 2.81))
x
x[[c(1,3)]] # third element of the first element
x[[1]][[3]] # third element of the first element
x[[c(2,1)]] # first element of the second element

# Partial Matches work with [[ and $
x <- list(aardvark = 1:5)
x$a
x[["a"]] # broken
x[["a", exact = FALSE]] # works
x <- list(aardvark = 1:5, asshole = 6:10)
x$a # broken
x$as # works

# Find and remove NA values for Vector, List, DF
x <- c(1,2,NA,4,NA,5)
bad <- is.na(x) # create a logical vector
bad
x[!bad] # list all x elements that are ! bad

# Find a subset of multiple things (where the index for neither x nor y is na)
# complete.cases works for data frames too
x <- c(1,2,NA,4,NA,5)
y <- c("a","b",NA,"d",NA,"f")
good <- complete.cases(x,y)
x[good] # returns 4 elements
y[good] # returns 4 elements

x <- c(1,2,NA,4,NA,5)
y <- c("a",NA,NA,NA,NA,"f")
good <- complete.cases(x,y)
x[good] # returns 2 elements
y[good]# returns 2 elements

# Many functions are vectorized, meaning that they happen in parallel. 
x <- 1:3
y <- 1:3
x * y # = x[1] * y[1], x[2] * y[2], x[3] * y[3]
x + y # = x[1] + y[1], x[2] + y[2], x[3] + y[3]
x > 2 # looks at all elements and gives a list of logicals(aka booleans) back

# Matrix vectorized operations
m <- matrix(1:9, nrow = 3, ncol = 3)
n <- matrix(1:9, nrow = 3, ncol = 3)
m * n # NOT matrix multiplication, simple element by element multiplication
m %*% n # TRUE matrix multiplication
m <- matrix(1:6, nrow = 3, ncol = 2)
n <- matrix(1:6, nrow = 2, ncol = 3)
m %*% n # TRUE matrix multiplication
n %*% m







