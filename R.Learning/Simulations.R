# Any time you generate random numbers for a simulation, it is important to set.seed so that you can reproduce your work later
set.seed(1)

# simulating numbers from distributions
rnorm() # generate numbers from a normal dist with a mean and std dev
dnorm() # evaluate the normal probability densities at a point (or vector of points) with a given mean/SD
pnorm() # evaluate the cumulative distribution function for a normal dist
rpois() # generate random Poisson variates with a given rate (from a Poissin distribution)

### for any given distribution, there will be a function that starts with the following letters
# d for density
# r for random number generation
# p for cumulative probability distribution
# q for quantile function

# Working with a normal dist 
q <- 100
p <- 100
dnorm(x, mean = 0, sd = 1, log = FALSE)
pnorm(q, mean = 0, sd = 1, lower.tail = TRUE, log.p = FALSE)
qnorm(p, mean = 0, sd = 1, lower.tail = TRUE, log.p = FALSE)
rnorm(n, mean = 0, sd = 1)
# The lower tail = TRUE means it defaults to displaying the left portion of the dist. If you are + 3 sigma, it will return 99.x%
# If you want to evaluate the right side, you specify lower.tail = FALSE

# using set.seed pulls the same sudo random numbers. Notice how I can generate the same vector after I reset seed...
set.seed(1)
x <- rnorm(10)
x
x <- rnorm(10, 20, 2)
x
set.seed(1)
x <- rnorm(10)
x

### Poisson distributions
# Generate poisson variables
rpois(10,1)
rpois(10,2)
rpois(10,20)

# What is the probability that a random variable is < or = 4 if the rate is 2?
ppois(2,2) # Probability that x <= 2
ppois(4,2) # Probability that x <= 4
ppois(6,2) # Probability that x <= 6

### What if you want to generate random data from a model? 
# a simple linear model with one predictor (x) and random noise (e for epsilon)
# y = B0 + B1x + e
# Where e ~ N(0,2^2), x ~ N(0,1^2), B0 = .5, B1 = 2
set.seed(20)
x <- rnorm(100)
e <- rnorm(100,0,2)
y <- 0.5 + 2 * x + e
summary(y)
plot(x,y)

### What if x was not a normal variable but a binary var?
### x may represent gender or a treatment v control
set.seed(10)
x <- rbinom(100,1,0.5)
e <- rnorm(100,0,2)
y <- 0.5 + 2 * x + e
summary(y)
plot(x,y)

### Creating data from a more complex model
# Y ~ Poisson(u)
# log u = B0 + B1x
set.seed(1)
x <- rnorm(100)    # standard normal dist
log.mu <- 0.5 + 0.3 * x    # set the linear predictor, B0 + B1 * x 
y <- rpois(100, exp(log.mu))  # in order to get the mean, we need to exponentiate the log.mu
summary(y)
plot(x,y)


### Sample functions allow you to draw randomly from a vector of numbers or a dist
set.seed(1)
sample(1:10, 4)   # no reuse of numbers (called replacement)
sample(1:10, 11)  # Won't work, not enough numbers without replacement
sample(letters, 5)
sample(1:10)
sample(1:10, replace = TRUE) # gives numbers more than once













