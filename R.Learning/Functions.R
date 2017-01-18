f <- function(<arguments>) {
  # do something
}

# Functions are normal objects, can be passed to other functions, and can be nested
# Functions have named args and can have default values

# Print the arguments for a given function
args(sd)

# You can list args by position or by name. Names can be out of order
mydata <- rnorm(100)
order(mydata)
sd(mydata)
sd(x = mydata)
sd(x = mydata, na.rm = FALSE)
sd(na.rm = FALSE, x = mydata)

# Function arguments work with partial matches so long as they are unique


# Defining a function
f <- function(a, b = 1, c = 2, d = NULL) {
  # do something
}

# Lazy evanuation: args are evaluated lazily (as needed) so this example will work:
f <- function(a, b) {
  a^2
}
f(2)


# this throws an error when you get to B (lazy execution), because there is no default, 
f <- function(a, b) {
  print(a)
  print(b)
}
f(2)

# the ... indicates a variable number of args
# myplot will replicate most of the args of the plot function
myplot <- function(x,y,type = integer, ...) {
  plot(x,y,type = type, ...)
}
myplot(x = 2, y = 2)

args(plot)






