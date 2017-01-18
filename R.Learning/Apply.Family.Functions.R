# lapply: loop over lists and apply a function to each element
# Whatever goes in is coerced into a list, and returned as a list
x <- list(a = 1:5, b = rnorm(10))
x
lapply(x, mean)

# Similar example but with more data. E has a ton of samples
x <- list(a = 1:5, b = rnorm(10), c = rnorm(20,1), d = rnorm(100,5), e = rnorm(10000000,5))
lapply(x, mean)

# runif generates random variables. Arg n is the number of vars to create
x <- 1:4
args(runif)
lapply(x, runif)

# Lapply can pass extra args to functions too by appending at the end:
x <- 1:4
lapply(x, runif, min = 0, max = 10)

# Lapply uses anonymous functions (functions that are not explicitly named)
x <- list(a = matrix(1:4,2,2), b = matrix(1:6,3,2))
x
# If you want to extract just the first column from both of these matrices
# There is no existing function to extract the first col, must write your own
lapply(x, function(elt) elt[,1])
# The elt function only exists inside the lapply and is gone post execution
# This is an anonymous function

# Sapply is a varient that simplifies the result if possible.
# If every item in the list has only a single element, a vector is returned
# If every item in the list has the same number of elements > 1, a matrix is returned
# Else a list is returned
x <- list(a = 1:5, b = rnorm(10), c = rnorm(20,1), d = rnorm(100,5), e = rnorm(10000000,5))
y <- sapply(x, mean)
z <- lapply(x, mean)
str(y)
str(z)
mean(x) # won't work because it can't handle lists. Why *apply is useful. 


### APPLY FUNCTION
# Used to evaluate a function over the margins of an array
# Apply a function to rows or columns of a matrix
# Take the avg of an array of matrices
# same speed as writing a loop, but one line of code
str(apply)
# X = an array, MARGIN = which margins should be retained, FUN = what to apply
x <- matrix(rnorm(200),20,10)
apply(x, 2, mean) # 2 = columns
apply(x, 1, sum) # 1 = rows
# Think of this as colapsing a dimension of the array by summing, etc. 

### For simple apply like functions, there are some specialized functions that are much faster
rowSums = apply(x, 1, sum)
rowMeans = apply(x, 1, mean)
colSums = apply(x, 2, sum)
colMeans = apply(x, 2, mean)

# If you want the .25 and .75 quantile
x <- matrix(rnorm(200),20,10)
apply(x, 1, quantile, probs = c(0.25, 0.75))
# prserves the rows and runs quantiles on them

# If you have an array and not just a matrix
a <- array(rnorm(2 * 2 * 10), c(2,2,10))
apply(a, c(1,2), mean)
rowMeans(a, dims = 2) # not a matrix but will still work with arrays

### TAPPLY
# Apply a function to a subset of a vector (don't know why it is called tapply)
str(tapply)
# x=vector, INDEX is a factor or list of factors, FUN = function, ... = args to the FUN, simplify = TRUE/FALSE
x <- c(rnorm(10), runif(10), rnorm(10,1))
# Gl generates factors. This is 3 groups of 10 elements
f <- gl(3,10)
x
f
tapply(x,f,mean)
# So this takes x, splitting on f, and takes the mean
tapply(x,f,mean, simplify = FALSE)
# A more complex function returnes a list with vectors of length 2
tapply(x,f,range)

### SPLIT
str(split)
x <- c(rnorm(10), runif(10), rnorm(10,1))
f <- gl(3,10)

split(x,f)
# Lists are returned based on the functions
# Common to use lapply and sapply with split
lapply(split(x,f), mean)

# load sample data
library(datasets)
head(airquality)

# If you want to sample the mean of oz, temp, etc by month
# Split by month, then take means
s <- split(airquality, airquality$Month)
lapply(s, function(x) colMeans(x[, c("Ozone", "Solar.R", "Wind")]))
sapply(s, function(x) colMeans(x[, c("Ozone", "Solar.R", "Wind")]))
# Remove NA's from the data to get means for all values
sapply(s, function(x) colMeans(x[, c("Ozone", "Solar.R", "Wind")], na.rm = TRUE))

# Splitting on more than 1 level
x <- rnorm(10)
f1 <- gl(2,5)
f2 <- gl(5,2)
f1
f2
# Interaction function combines all the levels of f1 with f2 (like Peri Labs trials)
interaction(f1, f2)
str(split(x, list(f1, f2))) # the interaction fun is implied and split knows to merge f1 & f2
# not all levels have elements because of the rnorm distribution
# you can use drop = TRUE to skip the empties
str(split(x, list(f1, f2), drop = TRUE))

### MAPPLY 
# a multivariate apply of sorts which applies functions in parallel over a set of args
list(rep(1, 4), rep(2, 3), rep(3, 2), rep(4, 1))
# Is equal to
mapply(rep, 1:4, 4:1)

# another example
# noise function creates 5 random samples around a mean and sd. 
noise <- function(n, mean, sd) {
  rnorm(n, mean, sd)
}
noise(5,1,2)
# this does not work correctly if a vector of elements is passed in
# what we want is 1 rand element with a mean of 1, 2 rand elements with mean 2, 3 rand el...
# that is not what we get:
noise(1:5, 1:5, 2)
# a better way:
mapply(noise, 1:5, 1:5, 2)
# is the same as:
list((noise, 1, 1, 2), (noise, 2, 2, 2), (noise, 3, 3, 2), (noise, 4, 4, 2), (noise, 5, 5, 2))
# so mapply applies the n and mean to function noise
### It vectorizes a function that does not allow for vector inputs. 
### THIS IS IMPORTANT, REMEMBER THIS



# random examples
data(mtcars)

mtcars

# take mean of cyl grouped on a factor of MPG (meaningless since each MPG is different, just creates a list of all cars)
tapply(mtcars$cyl, mtcars$mpg, mean)
# take the mean of all columns
apply(mtcars, 2, mean)
# take the mean of MPG grouped by # of cyl
tapply(mtcars$mpg, mtcars$cyl, mean)

re